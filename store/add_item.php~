<?php
	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
	$Item_Name=$_POST['Item_Name'];



	$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
	$len = strlen($word);
	$item_id="";
	for($i=0;$i<10;$i++)
	{
		$item_id.=$word[rand() % $len];
	}

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$result=$db->query("INSERT INTO `".$SerialNumbers."`(`ID`,`Name`,`State`,`Value`,`Now_Value`) VALUES ('".$item_id."','".$Item_Name."','STOP','0','0')");

	if($result)
	{
		echo "success";
		exit;
	}

	else
	{

		echo "fail";


	}
?>
	
	
