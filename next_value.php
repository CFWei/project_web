<?php
/*
require_once("session.php");
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$SerialNumber=$_GET['SerialNumber'];
$Item_Id=$_GET['Item_Id'];
$State=$_GET['State'];

//$SerialNumber="AGgnGwIhGMZWIPecEQ4B";
//$Item_Id="eyaP1gPTbI";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT Now_Value FROM ".$SerialNumber." WHERE ID = '".$Item_Id."'";
$db->query($query);

$temp=$db->fetch_array();
$Now_Value=$temp['Now_Value'];
$Now_Value++;

$query="UPDATE `".$SerialNumber."` SET `Now_Value`=\"".$Now_Value."\" where `ID` =\"".$Item_Id."\"";
$db->query($query);

header("Refresh:0; url=\"manager.php\"");
*/

?>
