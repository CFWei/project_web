<?php
	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");
	
	$SerialNumbers=$_POST['SerialNumbers'];
	$ID=$_POST['ID'];
	$EditValue=$_POST['EditValue'];


	
	//$SerialNumbers="j5I5hh56nZVNqG3N4WcM";
//	$ID="7PQSzAnpec";
//	$EditValue="";


	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="SELECT Value,Now_Value FROM ".$SerialNumbers." WHERE ID='".$ID."'";
	$db->query($query);
	
	$temp=$db->fetch_assoc();
	$Now_Value=$temp['Now_Value'];
	$Value=$temp['Value'];
	
	$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ID."' and number='".$EditValue."'";
	$db->query($query);


	if($db->get_num_rows()>0)
	{	
		$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$EditValue."\" where `ID` =\"".$ID."\"";
		$db->query($query);
		echo "success";
	}
	else
	{
		echo "fail";

	}
	


?>
