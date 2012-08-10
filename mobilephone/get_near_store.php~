<?php 

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$limit_distance=5000;

function getDis($lat1,$lat2,$lng1,$lng2)
{
	$radLat1 = deg2rad($lat1);
	$radLat2 = deg2rad($lat2);

	$a = $radLat1 - $radLat2;
	$b = deg2rad($lng1) - deg2rad($lng2);

	$s = 2*asin(sqrt( pow(sin($a*0.5),2) + cos($radLat1)*cos($radLat2)*pow(sin($b*0.5),2) ));

	$s = $s*6378137;

	return $s;
}


$logitude=$_POST['logitude'];
$latitude=$_POST['latitude'];

//$logitude="120.2360508";
//$latitude="23.0025696";


$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$query="SELECT StoreName,StoreAddress,StoreTelephone,GPS_Longitude,GPS_Latitude,SerialNumbers FROM store_information";
$db->query($query);

//$near_store_list[];

while(($temp=$db->fetch_assoc())!=null)
{
	$distance=getDis((double)$latitude,(double)$temp['GPS_Latitude'],(double)$logitude,(double)$temp['GPS_Longitude']);
	
	//$distance=getDis(120,120.1,23,23.1)."<br>";
	//echo $distance.<br>";
	
	if($distance<=$limit_distance)
	{
		$temp['distance']=$distance;
		$near_store_list[]=$temp;
	}
	



}


echo json_encode($near_store_list);
?>
