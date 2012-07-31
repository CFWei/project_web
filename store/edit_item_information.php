<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");


$ID=$_POST['ID'];
$SerialNumbers=$_POST['SerialNumbers'];
$Name=$_POST['Name'];



//$ID="uFtCLJsFu3";
//$SerialNumbers="j5I5hh56nZVNqG3N4WcM";
//$Name="123";



$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$query="UPDATE ".$SerialNumbers." SET Name='".$Name."' where ID='".$ID."'";


$db->query($query);

echo "success";




?>
