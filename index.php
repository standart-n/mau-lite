<?php session_start();
	foreach (explode("|","main|base") as $key) { $f='class/class_'.$key.'.php'; if (file_exists($f)) { include_once($f); } }
	if (class_exists("main")) { $main=new main;	$main->engine(); echo $main->q->html; }
?>
