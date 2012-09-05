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

if(isset($_POST['StoreItemName']))
{	

	$StoreItemName=$_POST['StoreItemName'];

	$query="INSERT INTO `StoreTakenItem` (`Store`,`ItemName`) VALUES ('".$SerialNumbers."','".$StoreItemName."')";
	$db->query($query);
	

}

$query="SELECT * FROM StoreTakenItem WHERE Store='".$SerialNumbers."'";
$db->query($query);


?>
<div>
	<div id="StoreItemList">
		<div class="StoreItemListTr">
			<div class="StoreItemListTd">
				商品名稱
			</div>
			<div class="StoreItemListTd">
				商品狀態
			</div>
		</div>
		<?php
			while(($temp=$db->fetch_assoc())!=null)
			{
				echo '<div class="StoreItemListTr">';
				
				echo '<div class="StoreItemListTd">';
				echo $temp['ItemName'];
				echo '</div>';

				echo '<div class="StoreItemListTd">';
				echo '</div>';
			
				echo '</div>';

			}
		?>
	</div>
	

	<div id="AddStoreItem">
		<h1>新增商品</h1>
		<form method="post" action="">
			名稱:<input id="AddStoreItemName" type="text" name="ItemName">		
		</form>
	<button id="AddStoreItemButton">送出</button>
</div>
<div>

<script>
$("#AddStoreItemButton").click(
	function()
	{
		var StoreItemName=$("#AddStoreItemName").val();
		$('#content').load('StoreTakenItemList.php',{"StoreItemName":StoreItemName},
							function()
							{
								
							}
						);
		
	});


</script>
