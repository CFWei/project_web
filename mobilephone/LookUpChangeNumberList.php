<?php

require_once("../connect_mysql_class.php");
require_once("../mysql_inc.php");

$CustomID=$_POST['CustomID'];
$ItemID=$_POST['ItemID'];
$StoreID=$_POST['StoreID'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//選擇使用者此item 欲向前或向後換號

$query="SELECT * FROM ChangeNumberList WHERE CustomID='".$CustomID."' and ItemID ='".$ItemID."' and Store='".$StoreID."'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "-1";
	exit;
}

$temp=$db->fetch_assoc();
$Choose=$temp['Choose'];

//將SelectChoose設定為反向
if($Choose=="1")
	$SelectChoose="2";
if($Choose=="2")
	$SelectChoose="1";


$query="SELECT * FROM ChangeNumberList WHERE CustomID !='".$CustomID."' and ItemID ='".$ItemID."' and Store ='".$StoreID."' and Choose ='".$SelectChoose."' and State='0'";

$db->query($query);


while(($temp=$db->fetch_assoc())!=null)
{
	$output[]=$temp;
}

for($i=0;$i<count($output);$i++)
{
	$query="SELECT number FROM custom_information where custom_id ='".$output[$i]['CustomID']."' and store ='".$output[$i]['Store']."' and item = '".$output[$i]['ItemID']."'";
	$db->query($query);
	$temp=$db->fetch_assoc();
	$output[$i]['number']=$temp['number'];

}

echo json_encode($output);
?>
