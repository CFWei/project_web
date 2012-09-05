<?php
require_once("session.php");
$se=new session();	
if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "-1";
	exit();
}
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$Number=$_POST['Number'];
$ItemID=$_POST['ItemID'];

$query="UPDATE custom_information SET life='1' where store='".$SerialNumbers."' and item='".$ItemID."' and number='".$Number."'";
//$db->query($query);


$query="SELECT * FROM custom_information where store='".$SerialNumbers."' and item='".$ItemID."' and life='0' order by number";
$db->query($query);

$NextValue=-2;

while($temp=$db->fetch_array())
{
	if($temp['number']>$Number)
	{
		$NextValue=$temp['number'];
		break;
	}
}

echo $NextValue;

?>
