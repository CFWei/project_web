
<?php
require_once("session.php");
$session=new session();


if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);

if($db->get_num_rows()!=1)
{
	echo "取得ItemID失敗";
	exit;
}

$temp=$db->fetch_array();
$ItemID=$temp['ID'];

$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);

//找出所有商品清單 之後轉換名字用
while($temp=$db->fetch_array())
{
	$TakenItemIDList[]=$temp['TakenItemID'];
	$TakenItemNameList[]=$temp['ItemName'];
	$TakenItemPriceList[]=$temp['Price'];
}


$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' AND item='".$ItemID."' AND number='".$_POST['CustomNumber']."'";
$db->query($query);
?>


<div>這是第 <font size="13"><?php echo $_POST['CustomNumber'] ?></font> 號客戶的商品列表</div>
<div id="ItemListBlock">
		<div class="ItemListTr">
			<div class="ItemListTd">
				商品名稱
			</div>
			<div class="ItemListTd">
				商品數量
			</div>
			<div class="ItemListTd">
				商品單價
			</div>
		</div>
		<?php	
			$TotalCost=0;
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
					
					echo '<div class="ItemListTr">';
				
					echo '<div class="ItemContentTd">';
					$Record=0;
					
					for($i=0;$i<count($TakenItemIDList);$i++)
					{	
						if($TakenItemIDList[$i]==$TakenItemID)		
						{
							echo $TakenItemNameList[$i];
							$Record=$i;

						}
							
					}
					
					echo '</div>';

					echo '<div class="ItemContentTd">';
					echo $NeedValue;
					echo '</div>';
					
					echo '<div class="ItemContentTd">';
					echo $TakenItemPriceList[$Record];
					echo '</div>';

					echo '</div>';
					$TotalCost+=(int)$TakenItemPriceList[$Record]*(int)$NeedValue;
				}

			}
		?>
				
</div>

總金額: <?php echo $TotalCost ?> 元
