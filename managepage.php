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

function addItem($ItemID,$ItemName,$ItemValue,$ItemNowValue,$SerialNumbers)
{
	$content='<div id="'.$ItemID.'" class="ItemBlock">
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
						<div "NowValue" class="NowValue">
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




while($ItemData=$db->fetch_array())
{	
		
	$ItemID=$ItemData['ID'];
	$ItemName=$ItemData['Name'];
	$ItemValue=$ItemData['Value'];
	$ItemNowValue=$ItemData['Now_Value'];
	$ItemOutput[]=addItem($ItemID,$ItemName,$ItemValue,$ItemNowValue,$SerialNumbers);
}



echo '<div id="ItemTable" class="ItemTable">';
for($i=0;$i<count($ItemOutput);$i++)
{	

	if($i%2==0)
	{
		if($i!=0)
			echo '</div>';	
		echo '<div class="ItemTr">';
	}
	
	echo '<div class="ItemTd">';
	echo $ItemOutput[$i];
	echo '</div>';


}
echo '</div>';	
echo '</div>';

echo'<script>';	
echo'$(document).ready(UpdateValue());';
echo'RegisterContextMenu()';
echo'</script>';

?>
<div class="contextMenu" id="myMenu1" style="display:none;">
	<ul>
		<li id="delete">刪除商品</li>		
	</ul>
</div>



	
