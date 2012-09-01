<?php
//-1:在ChangeNumberList中找不到此custom
//-2:找不到changemate
require_once("../mysql_inc.php");
require_once("../connect_mysql_class.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];

$query="SELECT MatchNumber FROM ChangeNumberList WHERE CustomID ='".$CustomID."' and ItemID ='".$ItemID."' and Store ='".$Store."'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo -1;
	exit;
}

$temp=$db->fetch_assoc();
$MatchNumber=$temp['MatchNumber'];

$query="SELECT CustomID FROM ChangeNumberList WHERE MatchNumber ='".$MatchNumber."' and CustomID !='".$CustomID."'";
$db->query($query);
if($db->get_num_rows()!=1)
{
	echo -2;
	exit;
}

$temp=$db->fetch_assoc();
$MateID=$temp['CustomID'];

$query="SELECT number FROM custom_information where custom_id='".$MateID."' and store = '".$Store."' and ItemID = '".$ItemID."'";
$db->query($query);

$temp=$db->query($query);
$Number=$temp['number'];

$output[0]['number']=$Number;
$output[0]['MateID']=$MateID;

echo json_encode($output);

?>
