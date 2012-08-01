<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$StoreName=$_POST['StoreName'];
$StoreAddress=$_POST['StoreAddress'];
$StoreTelephone=$_POST['StoreTelephone'];
$GPS_Longitude=$_POST['GPS_Longitude'];
$GPS_Latitude=$_POST['GPS_Latitude'];
/*
$SerialNumbers="j5I5hh56nZVNqG3N4WcM";
$StoreName="茶的魔手";
$StoreAddress="台南市永康區小東路477巷46弄1-42號";
$StoreTelephone="073532676";
$GPS_Longitude="120.23568";
$GPS_Latitude="23.000425";
*/

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="UPDATE `store_information` SET `StoreName`=\"".$StoreName."\",`StoreAddress`=\"".$StoreAddress."\",`StoreTelephone`=\"".$StoreTelephone."\",`GPS_Longitude`=\"".$GPS_Longitude."\",`GPS_Latitude` =\"".$GPS_Latitude."\" where `SerialNumbers` =\"".$SerialNumbers."\"";



$db->query($query);
echo "successful";
?>
