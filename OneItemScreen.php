<?php
require_once("session.php");
$session=new session();


if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}

if(!$StoreType=$session->get_value("StoreType"))
{
	echo "******************取得StoreType失敗******************";
	exit();
}


$ItemID=$_POST['ItemID'];

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE' and ID='".$ItemID."'";
$db->query($query);

if($db->get_num_rows()!=1){
	echo '發生了不明原因的錯誤';
	exit;
}
$ItemData=$db->fetch_array();

$ItemName=$ItemData['Name'];
$ItemValue=$ItemData['Value'];
$ItemNowValue=$ItemData['Now_Value'];
?>


<div id="OneItemScreen">

<?php
echo addItem($ItemID,$ItemName,$ItemValue,$ItemNowValue,$SerialNumbers);

function addItem($ItemID,$ItemName,$ItemValue,$ItemNowValue,$SerialNumbers)
{
	$content='<div id="'.$ItemID.'" class="OneItemBlock">
				<div class="ControlBlock">
					<button class="ControlButton" onclick="NextValue(\''.$ItemID.'\',1)">下一號</button>	
					<button class="ControlButton" onclick="NextValue(\''.$ItemID.'\',2)">跳過</button>
					<button class="ControlButton" onclick="LookUpCustomInformation(\''.$ItemID.'\')">使用者</button>
					<button class="ControlButton" onclick="EditValue(\''.$ItemID.'\')">輸入號碼</button>
				</div>
				<div class="InformationBlock">	
					<div class="ItemTop">
						<div class="ItemName">
							'.$ItemName.'
						</div>
						<div class="NowValue">
							'.$ItemNowValue.'
						</div>
					</div>
					<div class="ItemButtom">
						<div class="WaitNum">
							<span class="WaitNumText">
								等候人數：
							</span>
							<span id="4564" name="WaiNumValue" class="WaiNumValue">
								100
							</span>
						</div>
						<div class="TakenNum">
							<span class="TakenNumText">
								已抽號碼：
							</span>
							<span class="TakenNumValue">
								'.$ItemValue.'
							</span>
						</div>

					</div>
				</div>
			</div>';

	return $content;
}

?>
</div>
<script>
	UpdateOneItemScreen("<?php echo $ItemID;?>");
</script>
