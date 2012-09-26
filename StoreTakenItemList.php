<?php
require_once("session.php");
$se=new session();
if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

if(isset($_POST['StoreItemName'])&&isset($_POST['ItemPrice']))
{	
	
	//檢查是否有相同名稱商品已存在
	$query="SELECT * FROM StoreTakenItem WHERE Store ='".$SerialNumbers."' AND ItemName ='".$_POST['StoreItemName']."'";
	$db->query($query);
	if($db->get_num_rows()==0)
	{
		/*產生新的Item的key*/
		$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
		$len = strlen($word);
		$TakenItemID="";
		for($i=0;$i<10;$i++)
		{
			$TakenItemID.=$word[rand() % $len];
		}

		$StoreItemName=$_POST['StoreItemName'];
		$Price=$_POST['ItemPrice'];
		$query="INSERT INTO `StoreTakenItem` (`Store`,`ItemName`,`TakenItemID`,`Price`) VALUES ('".$SerialNumbers."','".$StoreItemName."','".$TakenItemID."','".$Price."')";
		$db->query($query);
	}
	else
	{
		echo "<script>alert('已有相同名稱商品存在');</script>";


	}
	

}

if(isset($_POST['DeleteItemName']))
{
	$query="Delete FROM StoreTakenItem WHERE ItemName ='".$_POST['DeleteItemName']."' AND Store ='".$SerialNumbers."'";
	$db->query($query);
}




$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);


?>

<div id="StoreItemListTable">
	<div class="StoreItemListTableTr">
		<div class="StoreItemListTableTd">
			<div id="AddStoreItem">
				<h1>新增商品</h1>
				<form method="post" action="">
					名稱:<input id="AddStoreItemName" type="text" name="ItemName"><br>
					價格:<input id="ItemPrice" type="text" name="ItemPrice">			
				</form>
			<button id="AddStoreItemButton">送出</button>
			</div>
		</div>
	
		<div class="StoreItemListTableTd">
			<div id="StoreItemList">
				<div class="StoreItemListTr">
					<div class="StoreItemListTd">
						商品名稱
					</div>
					<div class="StoreItemListTd">
						商品價格
					</div>
					<div class="StoreItemListTd">
						
					</div>
				</div>
				<?php
					while(($temp=$db->fetch_assoc())!=null)
					{
						echo '<div class="StoreItemListTr">';
				
						echo '<div class="StoreItemListTd" name="ItemName">';
						echo $temp['ItemName'];
						echo '</div>';

						echo '<div class="StoreItemListTd">';
						echo $temp['Price'];
						echo '</div>';
						echo '<div class="StoreItemListTd" ><button class="DeleteItem">刪除</button></div>';
			
						echo '</div>';

					}
				?>
			</div>




			
		</div>
	</div>
</div>
<div>

<script>
$("#AddStoreItemButton").click(
	function()
	{
		var StoreItemName=$("#AddStoreItemName").val();
		var ItemPrice=$("#ItemPrice").val();
		$('#content').load('StoreTakenItemList.php',{"StoreItemName":StoreItemName,"ItemPrice":ItemPrice},
							function()
							{
								
							}
						);
		
	});
$('.DeleteItem').click
(
	function()
	{	

		var ItemName=$(this).parent().parent().children('div[name="ItemName"]').html();
		check=confirm("你確定要刪除 \""+ItemName+"\" 嗎?");
		if(check)
		{
			$('#content').load('StoreTakenItemList.php',{"DeleteItemName":ItemName},
							function()
							{
								
							}
						);
		}
	}
);

</script>
