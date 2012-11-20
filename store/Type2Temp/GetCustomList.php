<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ".$SerialNumbers." where State !='DIE'";
$db->query($query);

$temp=$db->fetch_array();
$Item_Id=$temp['ID'];

$query="SELECT number FROM custom_information WHERE store='".$SerialNumbers."' and item='".$Item_Id."' and life=0";
$db->query($query);


if($db->get_num_rows()<=0)
{
	echo "-1";
}
else
{

	while($temp=$db->fetch_array())
	{
		$result[]=$temp;
	}
	echo json_encode($result);
}


?>
