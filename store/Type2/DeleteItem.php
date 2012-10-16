<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$ItemName=$_POST['ItemName'];


if($SerialNumbers==''||$ItemName=='')
{
	echo '-1';
	exit;

}

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="Delete FROM StoreTakenItem WHERE ItemName ='".$ItemName."' AND Store ='".$SerialNumbers."'";
$db->query($query);

echo '0';


?>
