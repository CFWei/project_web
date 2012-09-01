<?php

//-1:對方不存在在換號清單
//-2:對方狀態不是在等待換號
//1:發出要求成功

require_once("../mysql_inc.php");
require_once("../connect_mysql_class.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];
$MatchID=$_POST['MatchID'];

$query="SELECT State FROM ChangeNumberList WHERE CustomID ='".$MatchID."' and ItemID ='".$ItemID."' and Store ='".$Store."'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "-1";
	exit;
}
$temp=$db->fetch_assoc();

if($temp['State']!="0")
{
	echo "-2";
}

$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
$len = strlen($word);
$MatchNumber="";
for($i=0;$i<10;$i++)
{
	$MatchNumber.=$word[rand() % $len];
}


$query="Update ChangeNumberList SET State ='2' , MatchNumber = '".$MatchNumber."' where CustomID='".$MatchID."' and ItemID='".$ItemID."' and Store ='".$Store."'";
$db->query($query);

$query="Update ChangeNumberList SET State ='1' , MatchNumber = '".$MatchNumber."' where CustomID='".$CustomID."' and ItemID='".$ItemID."' and Store ='".$Store."'";

$db->query($query);

echo "1";

?>
