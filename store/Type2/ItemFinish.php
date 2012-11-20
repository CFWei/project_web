<?php
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$ItemID=$_POST['ItemID'];
$CustomNumber=$_POST['CustomNumber'];
$SerialNumbers=$_POST['SerialNumbers'];

//取得StoreItemID
$query="SELECT ID FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$StoreItemID=$temp['ID'];

//取得CustomID
$query="SELECT custom_id FROM custom_information where store='".$SerialNumbers."' and item='".$StoreItemID."' and number='".$CustomNumber."' and life='0'";
$db->query($query);
$temp=$db->fetch_array();
$CustomID=$temp['custom_id'];


//更新custom_information的item資訊
$query="Select * FROM custom_information where custom_id='".$CustomID."' and store ='".$SerialNumbers."' and life='0'";
$db->query($query);
$temp=$db->fetch_array();
$SelectItem=json_decode($temp['SelectItem']);
for ($i=0;$i<sizeof($SelectItem);$i++)
{
	if($SelectItem[$i]->TakenItemID==$ItemID)
	{
		//$SelectItem[$i]->Life=1;
		if($SelectItem[$i]->Life==0){
			$SelectItem[$i]->Life=2;
			$CheckNum=2;

			}
		else if($SelectItem[$i]->Life==2){

			$SelectItem[$i]->Life=1;
			$CheckNum=1;
			}
		else{}
	}
}
$SelectItem=json_encode($SelectItem);
$query="Update custom_information set `SelectItem` ='".$SelectItem."' where store ='".$SerialNumbers."' and custom_id='".$CustomID."' and life='0'";
$db->query($query);

//刪除清單裡面的item資訊
//$query="Delete FROM Type2".$StoreItemID." where ItemID ='".$ItemID."' and CustomID='".$CustomID."'";
//$db->query($query);


if($CheckNum==1){
	//刪除清單裡面的item資訊
	$query="Delete FROM Type2".$StoreItemID." where ItemID ='".$ItemID."' and CustomID='".$CustomID."'";
	$db->query($query);
}
else{
	$query="Update Type2".$StoreItemID." set Life ='2' where ItemID ='".$ItemID."' and CustomID='".$CustomID."'";
	$db->query($query);
}



echo $CheckNum;

?>
