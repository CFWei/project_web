<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];

$query="SELECT * FROM ChangeNumberList WHERE CustomID='".$CustomID."' and ItemID ='".$ItemID."' and Store ='".$Store."'";

$db->query($query);
if($db->get_num_rows()==0)
{
	echo 0;
	exit;

}

echo -1;



?>
