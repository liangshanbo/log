<?php
	date_default_timezone_set('Asia/Chungking');
	$now = getdate();
	$year = $now[year];
	$logName = $year.$_GET['month'].$_GET['day'];

	$fileName = './wap_log/log/'.$logName.'.txt';
	// $fileName = './wap_log/log/20160322.txt';

	if(file_exists($fileName)){
		$res = file_get_contents($fileName);
		$arr = array_reverse(explode('|',$res));
		echo json_encode($arr);
		// echo $res;
		// echo $res;
	}
	// echo $fileName;
?>