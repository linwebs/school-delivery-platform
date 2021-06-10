<?php

namespace socket;

ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

// Set time limit to indefinite execution
set_time_limit(0);

require_once __DIR__ . '/../config/app.php';

require_once 'login.php';
require_once 'send_ticket.php';
require_once 'count_ticket.php';
require_once 'ticket_status.php';

class tcp_multicast {

	/**
	 * IP address
	 * @var string
	 */
	private string $address;

	/**
	 * Port number
	 * @var integer
	 */
	private int $port;

	/**
	 * Error message
	 * @var string
	 */
	private string $msg;

	/**
	 * @var array
	 */
	private $clients;

	/**
	 * @var Socket
	 */
	private $sock;

	/**
	 * tcp_multicast constructor.
	 */
	public function __construct() {
		$this->address = SERVER_IP_ADDR;
		$this->port = 5701;

		if ($this->create_connection()) {
			echo '連線建立成功' . "\n";

			$this->clients = array($this->sock);

			$this->socket_connection();
		} else {
			echo '連線建立失敗: ' . $this->msg . "\n";
		}
	}

	/**
	 * tcp_multicast destruct
	 * Close socket connection
	 */
	public function __destruct() {
		// close the listening socket
		socket_close($this->sock);
	}

	/**
	 * Create socket connection
	 * @return bool
	 */
	private function create_connection(): bool {
		// create a streaming socket, of type TCP/IP
		if (!($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
			$this->msg = "socket_create() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		};

		// set the option to reuse the port
		if (!socket_set_option($this->sock, SOL_SOCKET, SO_REUSEADDR, 1)) {
			$this->msg = "socket_set_option() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		}

		// "bind" the socket to the address to $address, on port $port
		if (!socket_bind($this->sock, $this->address, $this->port)) {
			$this->msg = "socket_bind() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		}

		// start listen for connections
		if (!socket_listen($this->sock)) {
			$this->msg = "socket_listen() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		}

		return true;
	}

	/**
	 * Socket connection
	 */
	private function socket_connection() {
		$write = null;
		$except = null;

		// Loop continuously
		while (true) {
			// create a copy, so $clients doesn't get modified by socket_select()
			$read = $this->clients;

			// get a list of all the clients that have data to be read from
			// if there are no clients with data, go to next iteration
			if (socket_select($read, $write, $except, 0) < 1) {
				continue;
			}

			// check if there is a client trying to connect
			if (in_array($this->sock, $read)) {
				echo '連接中...' . "\n";

				// accept the client, and add him to the $clients array
				$this->clients[] = $new_sock = socket_accept($this->sock);

				// send the client a welcome message
				//socket_write($new_sock, "no noobs, but ill make an exception :)\n" . "There are " . (count($clients) - 1) . " client(s) connected to the server\n");

				socket_getpeername($new_sock, $ip);

				echo '已連接: ' . $ip . "\n";

				// remove the listening socket from the clients-with-data array
				$key = array_search($this->sock, $read);

				unset($read[$key]);
			}

			// loop through all the clients that have data to read from
			foreach ($read as $key => $read_sock) {
				// read until newline or 1024 bytes
				// socket_read while show errors when the client is disconnected, so silence the error messages
				$data = @socket_read($read_sock, MAXLEN);

				// check if the client is disconnected
				if ($data === false) {
					// remove client for $clients array

					socket_getpeername($this->clients[$key], $ip);

					socket_close($this->clients[$key]);
					unset($this->clients[$key]);

					echo '連線中斷: ' . $ip . "\n";

					continue;
				}

				if ($data == "exit") {
					// remove client for $clients array

					socket_getpeername($this->clients[$key], $ip);

					socket_close($this->clients[$key]);
					unset($this->clients[$key]);

					echo '連線關閉: ' . $ip . "\n";

					continue;
				}

				// trim off the trailing/beginning white spaces
				$data = trim($data);

				// check if there is any data after trimming off the spaces
				if (!empty($data)) {
					socket_getpeername($this->clients[$key], $ip);

					echo '已收到訊息來自: ' . $ip . "\n";

					$this->msg = '';
					if ($json = $this->json_parse($data)) {
						//echo '狀態: JSON 解析成功' . "\n";

						if (isset($json->action)) {
							echo '動作: ' . $json->action . "\n";
							switch ($json->action) {
								case 'login':
									if (isset($json->account) && isset($json->password)) {
										$login = new login();
										$login_status = $login->login($json->account, $json->password);
										if ($login_status) {
											//print_r($login_status);
											$send = $login_status;
										} else {
											$send = array(
												'action' => 'login',
												'status' => 'error',
												'msg' => '登入失敗',
												'token' => null,
												'type' => null
											);
										}
									} else {
										$send = array(
											'action' => 'login',
											'status' => 'error',
											'msg' => '無法取得帳號密碼',
											'token' => null,
											'type' => null
										);
									}
									break;

								case 'send_ticket':
									if(!isset($json->token)) {
										$send = array(
											'action' => 'send_ticket',
											'status' => 'error',
											'msg' => '無法取得token',
											'token' => null,
											'type' => null
										);
									} else if(isset($json->area) && isset($json->build) && isset($json->room) && isset($json->shop) && isset($json->meal) && isset($json->quantity)) {
										$send_ticket = new send_ticket();
										$send_ticket_status = $send_ticket->send_ticket($json->token, $json->area, $json->build, $json->room, $json->shop, $json->meal, $json->quantity);
										if($send_ticket_status) {
											$send = $send_ticket_status;
										} else {
											$send = array(
												'action' => 'send_ticket',
												'status' => 'error',
												'msg' => '餐點訂購失敗',
												'token' => null,
												'type' => null
											);
										}
									} else {
										$send = array(
											'action' => 'send_ticket',
											'status' => 'error',
											'msg' => '訂餐參數錯誤',
											'token' => null,
											'type' => null
										);
									}
									break;

								case 'count_ticket':
									if(!isset($json->token)) {
										$send = array(
											'action' => 'ticket_status',
											'status' => 'error',
											'msg' => '無法取得token',
											'count' => null
										);
									} else {
										$count_ticket = new count_ticket();
										$count_ticket_status = $count_ticket->count_ticket($json->token);
										if($count_ticket_status) {
											$send = $count_ticket_status;
										} else {
											$send = array(
												'action' => 'ticket_status',
												'status' => 'error',
												'msg' => '訂單筆數查詢失敗',
												'count' => null
											);
										}
									}
									break;

								case 'ticket_status':
									if(!isset($json->token)) {
										$send = array(
											'action' => 'ticket_status',
											'status' => 'error',
											'msg' => '無法取得token',
											'id' => null,
											'area' => null,
											'build' => null,
											'room' => null,
											'shop' => null,
											'meal' => null,
											'quantity' => null,
											'order_status' => null
										);
									} elseif(!isset($json->id)) {
										$send = array(
											'action' => 'ticket_status',
											'status' => 'error',
											'msg' => '無法取得訂單編號',
											'id' => null,
											'area' => null,
											'build' => null,
											'room' => null,
											'shop' => null,
											'meal' => null,
											'quantity' => null,
											'order_status' => null
										);
									} else {
										$ticket_status = new ticket_status();
										$ticket_status_status = $ticket_status->ticket_status($json->token, $json->id);
										if($ticket_status_status) {
											$send = $ticket_status_status;
										} else {
											$send = array(
												'action' => 'ticket_status',
												'status' => 'error',
												'msg' => '訂單狀態查詢失敗',
												'id' => null,
												'area' => null,
												'build' => null,
												'room' => null,
												'shop' => null,
												'meal' => null,
												'quantity' => null,
												'order_status' => null
											);
										}
									}
									break;

								default:
									echo '狀態: JSON 無此 action' . "\n";

									$this->msg = '無此action方式';
									$send = $this->json_error();
							}
						} else {
							echo '狀態: JSON 無 action 欄位' . "\n";

							$this->msg = 'action欄位錯誤';
							$send = $this->json_error();
						}
					} else {
						echo '狀態: JSON 解析錯誤' . "\n";

						if ($this->msg == '') {
							$this->msg = 'action欄位錯誤';
						}
						$send = $this->json_error();
					}

					$send = $this->json_output($send);

					socket_write($read_sock, $send . "\n");
				}

			} // end of reading foreach
			usleep(10);
		}
	}

	private function json_output($data): string {
		$output_json = json_encode($data, JSON_UNESCAPED_UNICODE);

		$output_length = mb_strlen($output_json);

		$output = "";

		if ($output_length < 10) {
			$output .= '000';
		} elseif ($output_length < 100) {
			$output .= '00';
		} elseif ($output_length < 1000) {
			$output .= '0';
		}
		$output .= $output_length;

		$output .= $output_json;

		return $output;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function json_parse($data) {
		if (mb_strlen($data) >= 4) {
			$count = mb_substr($data, 0, 4);

			if (is_numeric($count)) {
				$count = intval($count);
				$json = mb_substr($data, 4);

				if (mb_strlen($json) == $count) {
					return json_decode($json);
				} else {
					$this->msg = '資料checksum錯誤';
				}
			} else {
				echo $count;
				$this->msg = '資料checksum格式錯誤';
			}
		} else {
			$this->msg = '資料格式錯誤';
		}
		return false;
	}

	private function json_error(): array {
		return array('action' => 'none', 'status' => 'error', 'msg' => $this->msg);
	}
}

new tcp_multicast();
