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
$ItemID=$temp['ID'];

$query="SELECT Now_Value,Value FROM ".$SerialNumbers." where ID = '".$ItemID."' and State !='DIE'";
$db->query($query);
$temp=$db->fetch_array();
$NowValue=$temp['Now_Value'];

$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);

//找出所有商品清單 之後轉換名字用
while($temp=$db->fetch_array())
{
	$TakenItemIDList[]=$temp['TakenItemID'];
	$TakenItemNameList[]=$temp['ItemName'];
	$TakenItemPriceList[]=$temp['Price'];
}

//取出CustomInformation
$query="SELECT number,SelectItem FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ItemID."' and life=0";
$db->query($query);
if($db->get_num_rows()<=0)
{
	$result['CustomList']="-1";
}
else
{	
	while($temp=$db->fetch_array())
	{	
		$SelectItem=json_decode($temp['SelectItem']);
		$TotalCost=0;
		for($i=0;$i<count($SelectItem);$i++)
		{	
			for($j=0;$j<count($TakenItemIDList);$j++)
			{	
				if($TakenItemIDList[$j]==$SelectItem[$i]->TakenItemID)		
				{
					//echo $TakenItemNameList[$i];
					$SelectItem[$i]->ItemName=$TakenItemNameList[$j];
					$SelectItem[$i]->ItemPrice=$TakenItemPriceList[$j];

					$TotalCost+=(int)$TakenItemPriceList[$j]*(int)$SelectItem[$i]->NeedValue;
					break;
					
				}
							
			}
				
		}
		$SelectItem=json_encode($SelectItem);
		$temp['SelectItem']=$SelectItem;
		$temp['TotalCost']=$TotalCost;
		$temp['ItemName']=$ItemName;			
		$result['CustomList'][]=$temp;
	
	}
}

$result['NowValue']=$NowValue;
echo json_encode($result);
?>
