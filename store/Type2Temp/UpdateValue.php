<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//找ItemID
$query="SELECT * FROM ".$SerialNumbers." where State !='DIE'";
$db->query($query);

$temp=$db->fetch_array();
$Item_Id=$temp['ID'];


$query="SELECT number FROM custom_information WHERE store='".$SerialNumbers."' and item='".$Item_Id."' and life=0";
$db->query($query);

/*
if($db->get_num_rows()<=0)
{
	$result[1][]="-1";
}
else
{
	while($temp=$db->fetch_array())
	{
		$result[1][]=$temp['number'];
	}
}
*/

$query="SELECT Now_Value,Value FROM ".$SerialNumbers." WHERE ID ='".$Item_Id."'";
$db->query($query);
$temp=$db->fetch_array();
$result[0]['NowValue']=$temp['Now_Value'];
$result[0]['Value']=$temp['Value'];

echo json_encode($result);

?>

