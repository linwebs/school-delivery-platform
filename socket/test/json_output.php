<?php
// error
//$output_array = array('action' => 'login', 'status' => 'ok', 'msg' => '登入成功', 'token' => md5(uniqid(rand(), true)));

// success
$output_array = array('action' => 'login', 'status' => 'error', 'msg' => '登入失敗', 'token' => null);

$output_json = json_encode($output_array, JSON_UNESCAPED_UNICODE);

$output_length = mb_strlen($output_json);

if($output_length < 10) {
	echo '000' . $output_length;
} else if($output_length < 100) {
	echo '00' . $output_length;
} else if($output_length < 100) {
	echo '0' . $output_length;
} else {
	echo '' . $output_length;
}

echo $output_json;
