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

$query="SELECT * FROM StoreTakenItem WHERE Store = '".$SerialNumbers."'";
$db->query($query);
?>


<div id="WaitItemModeSetting">
<div style="font-size:30px">選擇要顯示的商品</div>

<?php
while($temp=$db->fetch_array()){

echo '<div>';
echo '<input type="checkbox" class="ItemSelectBox" name='.$temp['TakenItemID'].'></input>';
echo '<span>'.$temp['ItemName'].'</span>';
echo '</div>';

}
?>
<button id="SubmitButton" style="width:100px;font-size:20px;">確定</button>
</div>

<script>
	$('#SubmitButton').click(function(){
		var select=[];
		$('.ItemSelectBox').each(function(){

			if($(this).attr('checked'))
				select.push($(this).attr('name'));
		});

		var json = JSON.stringify(select);
		loadpage('#content','WaitItemModeList.php',json);
		});
</script>

