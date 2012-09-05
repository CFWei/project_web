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

$query="SELECT * FROM custom_information WHERE store='".$SerialNumbers."' AND item='".$ItemID."' AND number='".$_POST['CustomNumber']."'";
$db->query($query);
?>


<div>這是第 <?php echo $_POST['CustomNumber'] ?> 號客戶的商品列表</div>
<div id="ItemListBlock">
		<div class="ItemListTr">
			<div class="ItemListTd">
				商品名稱
			</div>
			<div class="ItemListTd">
				商品數量
			</div>
		</div>
		<?php
			while(($temp=$db->fetch_assoc())!=null)
			{
				echo '<div class="ItemListTr">';
				
				echo '<div class="ItemListTd">';
				echo $temp['custom_id'];
				echo '</div>';

				echo '<div class="ItemListTd">';
				echo '</div>';
			
				echo '</div>';

			}
		?>
				
</div>
