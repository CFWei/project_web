<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];


$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="DELETE FROM ChangeNumberList WHERE CustomID='".$CustomID."' and ItemID='".$ItemID."' and Store='".$Store."'";
$db->query($query);

echo "1";


?>
