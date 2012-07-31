<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT StoreName,StoreAddress,StoreTelephone,GPS_Longitude,GPS_Latitude FROM store_information  where SerialNumbers='".$SerialNumbers."'";


$db->query($query);


$temp=$db->fetch_assoc();
$store_information[]=$temp;



echo json_encode($store_information);



?>
