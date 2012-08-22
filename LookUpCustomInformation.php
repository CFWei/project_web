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

$ItemID=$_POST['ItemID'];

//$ID="ueuKJKpyMD";
//$store="5mrXWaA7wbYgindrQZmh";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$query="SELECT number,custom_id,life FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ItemID."'";

$db->query($query);


?>
<div id ="LookUpCustomInformationTable">
	<div class="TableTr">
		<div class="TableTd">
		號碼
		</div>
		<div class="TableTd">
		使用者ID
		</div>
		<div class="TableTd">
		狀態
		</div>
		<div class="TableTd">
		動作
		</div>
	</div>

<?php
while(($temp=$db->fetch_assoc())!=null)
{
	echo '<div class="TableTr">';
	/***************************/
	echo '<div class="TableTd">';
		echo '<span class="Number">';
			echo $temp['number'];
		echo '</span>';
	echo '</div>';

	echo '<div class="TableTd">';	
		echo '<span class="CustomID">';
			echo $temp['custom_id'];
		echo '</span>';
	echo '</div>';

	echo '<div class="TableTd">';
		if( $temp['life']=="0")
			echo "未服務";
		else if( $temp['life']=="1")
			echo "已服務";
		else if($temp['life']=="2")
			echo "已刪除";
		else
			echo "未定義";
	
	echo '</div>';
	/***************************/
	echo '	<div class="TableTd">';
	if($temp['life']==0)
	{
		echo '<button class="SkipButton">
					跳號
				</button>';
		echo '<button class="DeleteButton">
				刪除
			</button>';
	}
	echo '</div>';
	echo '</div>';
}

?>


<div>

<script>
	$('.SkipButton').click(function(){
				var ItemID = "<?php echo $ItemID?>";
				var EditValue = $(this).parent().parent().children('.TableTd').children('.Number').html();
				
				$.post('EditNum.php',
				      {"ItemID":ItemID,"EditValue":EditValue},
					function(data)
					{
						if(data==EditValue)
							loadpage("#content","managepage.php");
						else
						{
							alert("跳號失敗");	
						}
					},
					"text" );
				
			
				});	

	$('.DeleteButton').click(function(){
				var ItemID="<?php
						echo $ItemID;
						?>";
				var CustomID = $(this).parent().parent().children('.TableTd').children('.CustomID').html();
				var Value = $(this).parent().parent().children('.TableTd').children('.Number').html();
				$.post('ModifyCustomState.php',
					{"ItemID":ItemID,"CustomID":CustomID,"Value":Value},
					function(data)
					{
					},
					"text");					
				LookUpCustomInformation(ItemID);		
				
				});
</script>
