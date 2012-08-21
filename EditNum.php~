<?php
//-3:EditValue不是數字
//-2:無法取得SerialNumbers
//-1:沒有這個號碼
//其他正數：換號成功
	
	require_once("session.php");
	$se=new session();


	if(!$SerialNumbers=$se->get_value("SerialNumbers"))
	{
		echo "-2";
		exit();
	}	

	require_once("connect_mysql_class.php");
	require_once("mysql_inc.php");

	$ItemID=$_POST['ItemID'];
	$EditValue=$_POST['EditValue'];
	
	if(!is_numeric($EditValue))
	{
		echo -3;
		exit();
	}
	

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ItemID."' and number='".$EditValue."'";
	$db->query($query);

	if($db->get_num_rows()>0)
	{	
		$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$EditValue."\" where `ID` =\"".$ItemID."\"";
		//$db->query($query);
		echo $EditValue;
	}
	else
	{
		echo "-1";
	}
	
?>
