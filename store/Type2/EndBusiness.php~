<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


//找ItemID
$query="Select * FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
$temp=$db->fetch_assoc();
$ItemID=$temp['ID'];

//找尋還有這個商品號碼的人
$query="SELECT * FROM custom_information WHERE store ='".$SerialNumbers."' AND item ='".$ItemID."'";
$db->query($query);
//紀錄還有這個商品的人的個數
$count=$db->get_num_rows();

//發出通知 說這個商品已經結束了 
if($count!=0)
{

}

//將custom_information 有此商品的人life 設為1
$query="UPDATE custom_information SET life ='1' WHERE store ='".$SerialNumbers."' and item='".$ItemID."'";
$db->query($query);

//將此ITEM設為die
$query="UPDATE ".$SerialNumbers." SET State ='DIE' WHERE ID ='".$ItemID."'";
$db->query($query);

//刪除此表單
$query="DROP TABLE Type2".$ItemID;
$db->query($query);

echo "1";
?>

