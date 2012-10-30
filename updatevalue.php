<?php
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
require_once("session.php");
$se=new session();	
if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}

$Type=$_POST['Type'];
$Item_Id=$_POST['Item_Id'];

//$SerialNumbers='j5I5hh56nZVNqG3N4WcM';
//$Item_Id='7PQSzAnpec';

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

if($Type=="1")
{	

	//取得NowValue Value State
	$query="SELECT Now_Value , Value , State FROM ".$SerialNumbers." WHERE ID ='".$Item_Id."'";
	$db->query($query);
	$result=$db->fetch_array();

	$Now_Value=$result['Now_Value'];
	$Value=$result['Value'];
	$State=$result['State'];
	
	//取得WaiNumValue
	$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' and item='".$Item_Id."' and life=0 and number !='".$Now_Value."'";
	$db->query($query);

	$WaiNumValue=$db->get_num_rows();

	$output['Item_Id']=$Item_Id;
	$output['WaiNumValue']=$WaiNumValue;
	$output['Value']=$Value;
	$output['Now_Value']=$Now_Value;
	$output['State']=$State;

	echo json_encode($output);
	exit;
}
if($Type=="2")
{	
	//取得目前等待服務的號碼
	$query="SELECT number,SelectItem FROM custom_information WHERE store='".$SerialNumbers."' and item='".$Item_Id."' and life=0";
	$db->query($query);
	
	if($db->get_num_rows()<=0)
	{
		$Result['WaitCustomValue'][]="-1";

	}
	else
	{	
		$db1=new DB();
		$db1->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

		$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
		$db1->query($query);
	
		//找出所有商品清單 之後轉換名字用
		while($temp=$db1->fetch_array())
		{
			$TakenItemIDList[]=$temp['TakenItemID'];
			$TakenItemNameList[]=$temp['ItemName'];
			$TakenItemPriceList[]=$temp['Price'];
		}

		while($temp=$db->fetch_array())
		{	
			$output['number']=$temp['number'];
		
			//$Result['WaitCustomValue'][]=$temp['number'];
			
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
					if($ItemColumn=="Life")
						$Life=$Data;
							
				}
				
				for($i=0;$i<count($TakenItemIDList);$i++)
				{	
					if($TakenItemIDList[$i]==$TakenItemID)		
					{

						$Record=$i;

					}
							
				}
				$TotalCost+=(int)$TakenItemPriceList[$Record]*(int)$NeedValue;
			}

			$output['TotalCost']=$TotalCost;
			$Result['WaitCustomValue'][]=$output;
			

		}
			
			
	}

	$query="SELECT Now_Value,Value FROM ".$SerialNumbers." WHERE ID ='".$Item_Id."'";
	$db->query($query);
	$temp=$db->fetch_array();
	$Result['NowValue'][]=$temp['Now_Value'];
	$Result['Value'][]=$temp['Value'];
	echo json_encode($Result);
	exit;
}

function GetTakenItemIDList()
{
	global $SerialNumbers;	
	

	return $TakenItemPriceList;

}

function EvaluatePrice($EvaluateNumber)
{	
	
	global $SerialNumbers,$Item_Id,$TakenItemPriceList;
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	
	
	return $TotalCost;
}
?>






