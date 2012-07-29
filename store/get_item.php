<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$ID=$_POST['ID'];

//$SerialNumbers="j5I5hh56nZVNqG3N4WcM";
//$ID="2iVGaditZJ";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$query="SELECT * FROM ".$SerialNumbers." WHERE ID='".$ID."'";
$db->query($query);

$temp[]=$db->fetch_assoc();

echo json_encode($temp);

?>
