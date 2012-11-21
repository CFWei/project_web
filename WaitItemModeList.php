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

$SelectItem=json_decode($_POST['ItemID']);


for($i=0;$i<count($SelectItem);$i++)
{
	$query="Select ItemName From StoreTakenItem Where Store ='".$SerialNumbers."' and TakenItemID = '".$SelectItem[$i]."'";
	$db->query($query);
	$temp=$db->fetch_array();
	$ItemName[]=$temp['ItemName'];

}



?>
<div id="WaitItemModeList">
<?php
	for($i=0;$i<count($SelectItem);$i++){
	if($i%4==0&&$i!=0)
		echo '</div>';
	if($i%4==0)
		echo '<div class="WaitItemModeListTr">';


	echo '<div class="WaitItemModeListTd" name="'.$SelectItem[$i].'" >';
	echo $ItemName[$i];
	echo '<hr>';
	echo '<div class="WaitCustomList" name="'.$SelectItem[$i].'" ></div>';
	echo '</div>';
	}
	echo '</div>';

?>
	

</div>
<script>
var ItemID=[];
$('.WaitItemModeListTd').each(function(){
	
	ItemID.push($(this).attr('name'));
});


WaitItemModeUpdate(ItemID);


$('.CustomDataBlock').live("mouseover",function(){
$(this).css("background","yellow");
});

$('.CustomDataBlock').live("mouseout",function(){
$(this).css("background","white");
});

$('.CustomDataBlock').live("click",WaitItemClickEvent);


</script>

