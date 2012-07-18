<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$SerialNumbers=$_POST['SerialNumbers'];
//$SerialNumbers="eFm7hGveXcGCTNmqKEHf";

$query="SELECT * FROM ".$SerialNumbers;

$db->query($query);

if($db-> get_num_rows()<=0)
{
	echo "fail";
	exit;
}

while(($temp=$db->fetch_assoc())!=null)
{

$item_list[]=$temp;

}


echo json_encode($item_list);
?>
