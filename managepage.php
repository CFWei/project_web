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


require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);



if($StoreType=="1")
{
	$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE'";
	$db->query($query);
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
	echo '<div class="contextMenu" id="myMenu1" style="display:none;">
		<ul>
			<li id="delete">刪除商品</li>		
		</ul>
		</div>';

	exit;

}

if($StoreType=="2")
{

	$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE'";
	$db->query($query);
	if($db->get_num_rows()!=1)
	{
		echo "<span id='status'>尚未營運</span><br>";
		echo '<button onclick="StartBusiness()">開始營業</button>';
		exit;
	}
	$temp=$db->fetch_array();

	$ItemID=$temp['ID'];



}



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



?>
<div id="Type2Block">
	<div id="RightBlock">
		<div id="CustomItemListBlock">
		</div>
		<div id="ItemQueueBlock">
		</div>

	</div>
	<div id="LeftBlock">
		<div id="NumberBlock">
			<select id="NumberSelector" multiple="1">
			</select>
		</div>
		<div id="StatusBlock">
			<div style="font-size:25px;">目前號碼</div>
			<span id="NowValue" style="font-size:70px;">9999</span>
			<div>已抽號碼:<span id="Value">9999</span></div>
			<div>等候人數:<span id="WaitValue">9999</span></div>
		</div>
		<div id="ControlBlock">
			<button id="CallNumber" style="width:99%; height:99%; font-size:30px;">叫號</button>
		</div>
	</div>

</div>

<script>
$("#NumberSelector").change(function()
{	
	
	var Count=$(this).children("[selected]").size();
	if(Count>1)
	{
		alert("請勿選取兩個數");
		$('#NumberSelector').children().attr("selected",false);
		return;
	}
	
	if(Count!=0)
	{	
		
		$(this).children("[selected]").each(function(){
						
						loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":$(this).val()});
						
					});
	}
	if(Count==0)
	{	

		var Count=$(this).children().size();
		if(Count==1)
		{
			$(this).children().each(function(){
						
						loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":$(this).val()});
						
					});
		}

	}
});


$('#CallNumber').click(function()
		{	
			var Number=$('#NumberSelector').children("[selected]").val();
			if(!Number==undefined)
			{
				Type2NextValue(Number,'<?php echo $ItemID ?>');
			}
			else
			{
				var Count=$('#NumberSelector').children().size();
				if(Count==1)
				{
					$('#NumberSelector').children().each(function()
										{
											if($(this).attr("selected")==undefined)
												alert("請選取號碼");
											else
												Type2NextValue($(this).val(),'<?php echo $ItemID ?>');
										});
				}
				else
					alert("請選取號碼");
			}
		});



GetValue('<?php echo $ItemID ?>');
</script>

	
