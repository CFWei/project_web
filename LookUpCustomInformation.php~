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
$selector=$_POST['selector'];


//$ID="ueuKJKpyMD";
//$store="5mrXWaA7wbYgindrQZmh";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

if($selector==""||$selector==-1)
	{
		$query="SELECT number,custom_id,life FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ItemID."'";
		$t=0;
	}
else	
	{
		$query="SELECT number,custom_id,life FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ItemID."' and life='".$selector."'";
		$t=(int)$selector+1;
	}

$db->query($query);


$Selectcontent[$t]="selected";
?>
<div>
	<form name="SelectorForm">                                                                           
		<select name="Selector" onchange="LookUpCustomInformationSelector('<?php echo $ItemID ?>')">
			<option value=-1  <?php echo $Selectcontent[0] ?>>全部
			<option value=0  <?php echo $Selectcontent[1] ?>>未服務
			<option value=1 <?php echo $Selectcontent[2] ?>>已服務
			<option value=2 <?php echo $Selectcontent[3] ?>>已刪除
		</select>
				                                                              
		                                                                        
	</form>    
</div>
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
