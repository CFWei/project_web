<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$ID=$_POST['ID'];


$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT Value from ".$SerialNumbers." where ID = '".$ID."'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "fail";
	exit;
}

$temp=$db->fetch_assoc();
echo $temp['Value'];

?>
