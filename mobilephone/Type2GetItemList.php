<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$SerialNumbers=$_POST['SerialNumbers'];

//找這個store的ItemID
$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE' ";
$db->query($query);
$temp=$db->fetch_assoc();
$ItemID=$temp['ID'];


//擷取清單
$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);
while($temp=$db->fetch_assoc())
{
	$result[]=$temp;
}


echo json_encode($result);
?>
