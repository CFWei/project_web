<?php

require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$CallNumber=$_POST['CallNumber'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//找ItemID
$query="SELECT * FROM ".$SerialNumbers." where State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$ItemID=$temp['ID'];

//找NowValue
$query="SELECT Now_Value FROM ".$SerialNumbers." WHERE ID='".$ItemID."'";
$db->query($query);
$temp=$db->fetch_array();
$Now_Value=$temp['Now_Value'];


//找CustomID
$query="Select custom_id from custom_information where store='".$SerialNumbers."' and item ='".$ItemID."' and number ='".$CallNumber."' and life='0'";
$db->query($query);
$temp=$db->fetch_array();
$CustomID=$temp['custom_id'];

//檢查waititemlist是否已經空了 若沒有則回傳-1
$query="SELECT * FROM Type2".$ItemID." where CustomID ='".$CustomID."'";
$db->query($query);
if($db->get_num_rows()!=0){
	echo "-1";
	exit;
}

//將NowValue設為已服務
$query="UPDATE custom_information SET `life` = 1 where `store` ='".$SerialNumbers."' and item ='".$ItemID."' and number ='".$Now_Value."'";
$db->query($query);

$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$CallNumber."\" where `ID` =\"".$ItemID."\"";
$db->query($query);

$output['NowValue']=$CallNumber;
$output['LastNumber']=$Now_Value;

echo json_encode($output)

?>







