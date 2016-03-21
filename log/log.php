<?php
	date_default_timezone_set('Asia/Chungking');
	$log = $_POST['log'];

	$res = json_encode($log);
	$filename = './wap_log/log/'.date("Ymd",time()).'.txt';
	if(file_exists($filename)){
		file_put_contents($filename,'|'.$res,FILE_APPEND);
	}else{
		file_put_contents($filename,$res,FILE_APPEND);
	}
	// echo 'save';
?>