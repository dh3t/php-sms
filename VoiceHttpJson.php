<?php
/**
 * 大汉三通短信云平台语音http接入实例：json格式
 *
 */
//Base URL
define ( 'URL', "http://voice.3tong.net/json/voiceSms" );
//账号，必填
define ( 'ACCOUNT', "dh****" );
//密码，必填
define ( 'PASSWORD', md5 ( "17bT2NOB" ) );
//放音模式，必填
define ( 'PLAYMODE', "0" );
//外呼模式,必填
define ( 'CALLTYPE', "1" );

$ret = sendSms ( "13812345678", "1234", uniqid ( rand (), true ) );
$ret = getReport ();


/**
 * 发送短信
 * @param string $callee 手机号码,
 * @param string $text 短信内容
 * @param string $msgid 短信ID(唯一，UUID)，必填
 * 
 */
function sendSms($callee, $text, $msgid) {
	// 发送数据包json格式：{"account":"8528","password":"3fd3c885feb7457dab56c9a9678a123","data":[{"callee":"157****6131","text":"255178","calltype":1,"playmode":0}]}
	$message = [array ('msgid' => $msgid, 'callee' => $callee, 'text' => $text, 'playmode' => PLAYMODE, 'calltype' => CALLTYPE )];
	$data = array ('account' => ACCOUNT, 'password' => PASSWORD);
	$data['data'] = $message;
	return http_post_json ( __FUNCTION__, URL . "/SubmitVoc", json_encode ( $data ) );
}

/**
 * 获取短信状态报告
 * 
 */
function getReport() {
	// 获取短信状态报告数据包json格式：{"account":"8528","password":"3fd3c885feb7457dab56c9a9678a123"}
	$data = array ('account' => ACCOUNT, 'password' => PASSWORD );
	return http_post_json ( __FUNCTION__, URL . "/GetReport", json_encode ( $data ) );
}


/**
 * PHP发送Json对象数据, 发送HTTP请求
 *
 * @param string $url 请求地址
 * @param array $data 发送数据
 * @return String
 */
function http_post_json($functionName, $url, $data) {
	$ch = curl_init ( $url );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, 1 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen ( $data ) ) );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	$ret = curl_exec ( $ch );
	echo $functionName . " : Request Info : url: " . $url . " ,send data: " . $data . "  \n";
	echo $functionName . " : Respnse Info : " . $ret . "  \n";
	curl_close ( $ch );
	return $ret;
}
?>
