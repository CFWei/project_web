<?php
/*-1:錯誤*/
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$ID=$_POST['ID'];

//$SerialNumbers="j5I5hh56nZVNqG3N4WcM";
//$ID="7PQSzAnpec";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT  Now_Value , Value , State  from ".$SerialNumbers." where ID = '".$ID."'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "-1";
	exit;
}

$temp=$db->fetch_assoc();
$Now_Value=$temp['Now_Value'];
$Value=$temp['Value'];
$State=$temp['State'];

$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ID."' and life=0 and number !='".$Now_Value."'";
$db->query($query);

$WaitNumValue=$db->get_num_rows();

$output[0]['WaitNumValue']=$WaitNumValue;
$output[0]['Value']=$Value;
$output[0]['Now_Value']=$Now_Value;
$output[0]['State']=$State;


echo json_encode($output);

?>
