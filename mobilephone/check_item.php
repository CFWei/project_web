<?php
	//$custom_id=$_POST['custom_id'];
	$custom_id="1234";
	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="SELECT * FROM  custom_information where `custom_id` = '".$custom_id."'";
	$db->query($query);
	$db->get_num_rows();
	while($temp=$db->fetch_assoc())
		$output[]=$temp;
	
	echo json_encode($output);
?>