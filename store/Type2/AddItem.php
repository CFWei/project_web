<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$ItemName=$_POST['ItemName'];
$ItemPrice=$_POST['ItemPrice'];

if($SerialNumbers==""||$ItemName==""||$ItemPrice=="")
{
	echo "-2";
	exit;

}

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


//檢查是否有相同名稱商品已存在
$query="SELECT * FROM StoreTakenItem WHERE Store ='".$SerialNumbers."' AND ItemName ='".$ItemName."'";
$db->query($query);
if($db->get_num_rows()!=0)
{
	echo "-1";
	exit;
}


/*產生新的Item的key*/
$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
$len = strlen($word);
$TakenItemID="";
for($i=0;$i<10;$i++)
{
	$TakenItemID.=$word[rand() % $len];
}


$query="INSERT INTO `StoreTakenItem` (`Store`,`ItemName`,`TakenItemID`,`Price`) VALUES ('".$SerialNumbers."','".$ItemName."','".$TakenItemID."','".$ItemPrice."')";
$db->query($query);

echo "0";

?>
