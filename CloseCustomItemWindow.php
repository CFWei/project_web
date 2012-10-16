<?php
require_once("session.php");
$session=new session();

if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	exit();
}

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$Number=$_POST['Number'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT ID FROM ".$SerialNumbers." Where State !='DIE' ";
$db->query($query);
$temp=$db->fetch_array();
$ItemID=$temp['ID'];

$query="UPDATE custom_information SET `life` = 1 where `store` ='".$SerialNumbers."' and item ='".$ItemID."' and number ='".$Number."'";
$db->query($query);

?>
