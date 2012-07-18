<?php
require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$UserIMEI=$_POST['UserIMEI'];
$SerialNumbers=$_POST['SerialNumbers'];
$ItemId=$_POST['ItemId'];


//echo $UserIMEI."<br>".$SerialNumbers."<br>".$ItemId."<br>";
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT Value FROM ".$SerialNumbers." where ID='".$ItemId."'";

$db->query($query);


if($db->get_num_rows()!=1)
{

	echo "fail";
	exit;

}
$takevalue=0;
if($item=$db->fetch_assoc())
{
	$takevalue=(int)$item['Value'];
	$takevalue++;
}


$query="UPDATE ".$SerialNumbers." SET Value=".$takevalue." where ID='".$ItemId."'";

if(!$db->query($query))
	echo "fail";	


$query="INSERT INTO  `custom_information` (  `custom_id` ,  `store` ,  `item` ,  `number` )  VALUES ('".$UserIMEI."','".$SerialNumbers."','".$ItemId."','".$takevalue."')";

if(!$db->query($query))
	echo "fail";
else
	echo $takevalue;





?>
