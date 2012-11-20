<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);

while(($temp=$db->fetch_assoc())!=null)
{
	$result[]=$temp;

}

echo json_encode($result);

?>
