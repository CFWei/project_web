<?php

$store=$_POST['store'];
$item=$_POST['item'];

//$store="eFm7hGveXcGCTNmqKEHf";
//$item="fJIssVc8yA";

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT Now_Value from ".$store." where ID = '".$item."'";
//echo $query."<br>";
$db->query($query);

if($db->get_num_rows()==1)
{
	$temp=$db->fetch_assoc();
	echo $temp['Now_Value'];
}


?>
