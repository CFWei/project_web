<?php
//-1:無法取得SerialNumbers
require_once("session.php");
$session=new session();

if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "-1";
	exit();
}

$Num=$_POST['Num'];


require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT ID FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$ItemID=$temp['ID'];



$query="SELECT * FROM Type2".$ItemID." where Num='".$Num."'";
$db->query($query);
$temp=$db->fetch_array();
$CustomID=$temp['CustomID'];
$CustomItemID=$temp['ItemID'];




$query="Select * FROM custom_information where custom_id='".$CustomID."' and store ='".$SerialNumbers."' and life='0'";
$db->query($query);
$temp=$db->fetch_array();
$SelectItem=json_decode($temp['SelectItem']);

for ($i=0;$i<sizeof($SelectItem);$i++)
{
	if($SelectItem[$i]->TakenItemID==$CustomItemID)
	{
		$SelectItem[$i]->Life=1;
	}
}

$SelectItem=json_encode($SelectItem);
$query="Update custom_information set `SelectItem` ='".$SelectItem."' where store ='".$SerialNumbers."' and custom_id='".$CustomID."' and life='0'";
$db->query($query);



$query="Delete FROM Type2".$ItemID." where Num ='".$Num."'";
$db->query($query);


echo "1";

?>

