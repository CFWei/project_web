<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$Store=$_POST['Store'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//找到mathcnumber
$query="SELECT * FROM ChangeNumberList WHERE CustomID ='".$CustomID."' AND ItemID ='".$ItemID."' AND Store='".$Store."'";
$db->query($query);
$temp=$db->fetch_assoc();
$MatchNumber=$temp['MatchNumber'];

//找到要換號的對象
$query="SELECT * FROM ChangeNumberList WHERE CustomID !='".$CustomID."' AND MatchNumber='".$MatchNumber."'";
$db->query($query);
$temp=$db->fetch_assoc();
$MatchID=$temp['CustomID'];

//找到自己的號碼
$query="SELECT * FROM custom_information WHERE custom_id ='".$CustomID."' AND  item ='".$ItemID."' AND store='".$Store."' and life ='0'";
$db->query($query);
$temp=$db->fetch_assoc();
$CustomNumber=$temp['number'];

//找到要換號對象的號碼
$query="SELECT * FROM custom_information WHERE custom_id='".$MatchID."' AND item='".$ItemID."' AND store='".$Store."' AND life='0'";
$db->query($query);
$temp=$db->fetch_assoc();
$MatchIDNumber=$temp['number'];

//更新自己的號碼
$query="UPDATE custom_information SET number='".$MatchIDNumber."' where custom_id='".$CustomID."' and item ='".$ItemID."' AND store ='".$Store."' AND life='0'";
$db->query($query);

//更新對象的號碼
$query="UPDATE custom_information SET number='".$CustomNumber."' where custom_id='".$MatchID."' and item ='".$ItemID."' AND store ='".$Store."' AND life='0'";
$db->query($query);


//更新ChangeNumberList的狀態
$query="UPDATE ChangeNumberList SET STATE='3' where MatchNumber ='".$MatchNumber."'";
$db->query($query);

echo "1";

?>
