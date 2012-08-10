<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$ID=$_POST['ID'];
$store=$_POST['SerialNumbers'];
$Now_Value=$_POST['Now_Value'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM custom_information WHERE store='".$store."' and item='".$ID."' and life=0 and number !='".$Now_Value."'";
$db->query($query);

echo $db->get_num_rows();

?>
