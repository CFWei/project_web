<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$Item_Id=$_POST['Item_Id'];

//$SerialNumbers="5mrXWaA7wbYgindrQZmh";
//$Item_Id="ueuKJKpyMD";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$query="SELECT Now_Value FROM ".$SerialNumbers." WHERE ID = '".$Item_Id."'";


$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "fail";
	exit;
}

$temp=$db->fetch_array();
$Now_Value=$temp['Now_Value'];
$Now_Value++;


$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$Now_Value."\" where `ID` =\"".$Item_Id."\"";
$db->query($query);

echo $Now_Value;



?>