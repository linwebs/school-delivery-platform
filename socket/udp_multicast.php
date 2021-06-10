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

class udp_multicast {

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
		$this->port = 5702;

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
		if (!($this->sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP))) {
			$this->msg = "socket_create() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		};

		/*
		// set the option to reuse the port
		if (!socket_set_option($this->sock, SOL_SOCKET, SO_REUSEADDR, 1)) {
			$this->msg = "socket_set_option() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		}
		*/

		// "bind" the socket to the address to $address, on port $port
		if (!socket_bind($this->sock, $this->address, $this->port)) {
			$this->msg = "socket_bind() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		}

		// start listen for connections
		/*
		if (!socket_listen($this->sock)) {
			$this->msg = "socket_listen() 失敗的原因是:" . socket_strerror(socket_last_error()) . "\n";
			return false;
		}
		*/
		return true;
	}

	private function socket_connection2() {
		while (1) {
			echo "Waiting for data ... \n";

			//Receive some data
			$r = socket_recvfrom($this->sock, $data, MAXLEN, 0, $this->address, $this->port);
			echo "$this->address : $this->port -- " . $data;

			//Send back the data to the client
			socket_sendto($this->sock, "OK " . $data, 100, 0, $this->address, $this->port);
		}
	}


	/**
	 * Socket connection
	 */
	private function socket_connection() {

		// Loop continuously
		while (true) {
			$r = socket_recvfrom($this->sock, $data, MAXLEN, 0, $address, $port);

			// trim off the trailing/beginning white spaces
			$data = trim($data);

			// check if there is any data after trimming off the spaces
			if (!empty($data)) {
				if ($data == "exit") {
					continue;
				}

				echo '已收到訊息來自: ' . $address . ':' . $port . "\n";

				$this->msg = '';
				if ($json = $this->json_parse($data)) {
					//echo '狀態: JSON 解析成功' . "\n";

					if (isset($json->action)) {
						echo '動作: ' . $json->action . "\n";
						switch ($json->action) {

							case 'count_ticket':
								if (!isset($json->token)) {
									$send = array('action' => 'ticket_status', 'status' => 'error',
										'msg' => '無法取得token', 'count' => null);
								} else {
									$count_ticket = new count_ticket();
									$count_ticket_status = $count_ticket->count_ticket($json->token);
									if ($count_ticket_status) {
										$send = $count_ticket_status;
									} else {
										$send = array('action' => 'ticket_status', 'status' => 'error',
											'msg' => '訂單筆數查詢失敗', 'count' => null);
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

			}
			socket_sendto($this->sock, $send, MAXLEN, 0, $address, $port);
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

new udp_multicast();
