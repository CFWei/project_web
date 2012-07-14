<?php
require_once("session.php");
$se=new session();

if(!$se->get_value("SerialNumbers"))
	{
		echo "請先登入";
		exit;
	}
?>