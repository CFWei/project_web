<?php
//-1:沒有下一號 
//-2:找不到此商品

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$Item_Id=$_POST['Item_Id'];
$choose=$_POST['choose'];

//$SerialNumbers="5mrXWaA7wbYgindrQZmh";
//$Item_Id="ueuKJKpyMD";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT Now_Value,Value,State FROM ".$SerialNumbers." WHERE ID = '".$Item_Id."'";

$db->query($query);

//若找不到此商品則回傳fail
if($db->get_num_rows()!=1)
{
	echo "-2";
	exit;
}

$temp=$db->fetch_array();
$Now_Value=$temp['Now_Value'];
$Value=$temp['Value'];
$State=$temp['State'];


/*
$query="UPDATE custom_information SET life=1 where `store` ='".$SerialNumbers."' and `item`='".$Item_Id."' and `number`='".$Now_Value."'";
$db->query($query);
*/

$query="SELECT number,custom_id,life FROM custom_information WHERE store='".$SerialNumbers."' and item='".$Item_Id."' order by number";
$db->query($query);


$check=-1;
while($t=$db->fetch_array())
{
	//echo $t['number'];
	//echo $t['life'];
	//將目前號碼的使用者 life 設為 1(已服務
	if($t['number']==$Now_Value && $t['life']!=1 && $choose==1)
		{
			$db1=new DB();
			$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
			$query="UPDATE custom_information SET life=1 where `store` ='".$SerialNumbers."' and `item`='".$Item_Id."' and `number`='".$Now_Value."' and custom_id='".$t['custom_id']."'";
			$db1->query($query);
		}
	if($t['number']>$Now_Value && $t['life']==0 && $check==-1)
		{
			$check=$t['number'];
		
		}
}

echo $check;



if($check!=-1)
{
	$query="UPDATE `".$SerialNumbers."` SET `Now_Value`=\"".$check."\" where `ID` =\"".$Item_Id."\"";
	$db->query($query);

}


?>
