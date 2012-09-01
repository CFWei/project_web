<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ChangeNumberList WHERE CustomID='".$CustomID."' AND ItemID ='".$ItemID."' AND Store='".$Store."'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "-1";
	exit;
}


$temp=$db->fetch_assoc();
$MatchNumber=$temp['MatchNumber'];

$query="UPDATE ChangeNumberList SET State='0' , MatchNumber='' where CustomID='".$CustomID."' and ItemID='".$ItemID."' and Store='".$Store."'";
$db->query($query);

$query="UPDATE ChangeNumberList SET State='0' , MatchNumber='' WHERE MatchNumber='".$MatchNumber."'";
$db->query($query);

echo "1";


?>
