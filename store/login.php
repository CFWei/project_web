<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$Store_ID=$_POST['Store_ID'];
$Store_passwd=$_POST['Store_passwd'];

//$Store_ID="test1";
//$Store_passwd="test1";
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM store_information where `UserID` =  '".$Store_ID."' AND `UserPassword` ='".$Store_passwd."'";
$db->query($query);
if($db->get_num_rows()!=1)
{	
	echo "fail";
	exit;
}

else
{
	$temp=$db->fetch_assoc();
	echo $temp['SerialNumbers'];
}


?>
