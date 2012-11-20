<?php
//-1:取得itemid失敗
require_once("../../connect_mysql_class.php");
require_once("../../mysql_inc.php");

$SerialNumbers=$_POST['SerialNumbers'];
$CustomNumber=$_POST['CustomNumber'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "-1";
	exit;
}

$temp=$db->fetch_array();
$ItemID=$temp['ID'];

$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);

while($temp=$db->fetch_array())
{
	$TakenItemIDList[]=$temp['TakenItemID'];
	$TakenItemNameList[]=$temp['ItemName'];
	$TakenItemPriceList[]=$temp['Price'];
}


$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' AND item='".$ItemID."' AND number='".$CustomNumber."'";
$db->query($query);



//


$sp=0;
while(($temp=$db->fetch_assoc())!=null)
{

	$SelectItem=json_decode($temp['SelectItem']);
	foreach($SelectItem as $ItemTemp=>$ItemData)
	{	
		$TakenItemID="";
		$NeedValue="";
					
		foreach($ItemData as $ItemColumn=>$Data)
		{	
			if($ItemColumn=="TakenItemID")
				$TakenItemID=$Data;
			if($ItemColumn=="NeedValue")
				$NeedValue=$Data;
		}
					
		$Record=0;
					
		for($i=0;$i<count($TakenItemIDList);$i++)
		{	
			if($TakenItemIDList[$i]==$TakenItemID)		
			{
				$result[$sp]['ItemName']=$TakenItemNameList[$i];
				$Record=$i;

			}
							
		}
					

		$result[$sp]['NeedValue']=$NeedValue;
		$result[$sp]['Price']=$TakenItemPriceList[$Record];
		$sp++;
					
	}

}

echo json_encode($result);

?>
