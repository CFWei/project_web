<?php
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
require_once("session.php");
$se=new session();	
if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}
$Item_Id=$_POST['Item_Id'];
//$SerialNumbers='j5I5hh56nZVNqG3N4WcM';
//$Item_Id='7PQSzAnpec';

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT Now_Value , Value , State FROM ".$SerialNumbers." WHERE ID ='".$Item_Id."'";
$db->query($query);

$result=$db->fetch_array();
$Now_Value=$result['Now_Value'];
$Value=$result['Value'];
$State=$result['State'];

$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' and item='".$Item_Id."' and life=0 and number !='".$Now_Value."'";
$db->query($query);

$WaiNumValue=$db->get_num_rows();

$output['Item_Id']=$Item_Id;
$output['WaiNumValue']=$WaiNumValue;
$output['Value']=$Value;
$output['Now_Value']=$Now_Value;
$output['State']=$State;

echo json_encode($output);


?>





