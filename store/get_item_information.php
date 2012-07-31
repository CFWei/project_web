<?php
	require_once("../mysql_inc.php");
	require_once("../connect_mysql_class.php");

	$SerialNumbers=$_POST['SerialNumbers'];
	$ID=$_POST['ID'];

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


	$query="SELECT * FROM ".$SerialNumbers." WHERE ID='".$ID."'";
	$db->query($query);

	$temp[]=$db->fetch_assoc();

	echo json_encode($temp);


?>
