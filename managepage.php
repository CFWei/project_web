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
			<li id="OneItemScreen">此商品全螢幕</li>
			
			<li id="delete">刪除商品</li>		
		</ul>
		</div>';

	exit;
//<li id="LiveTakeNumber">現場取號系統</li>
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
							<span name="WaiNumValue" class="WaiNumValue">
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

	<div id="ItemQueueBlock">
			<script>
					//$('#ItemQueueBlock').load("ItemQueueList.php");
					ListStoreItem();
					$('.CustomDataBlock').live("mouseover",function(){
					$(this).css("background","yellow");
					});

					$('.CustomDataBlock').live("mouseout",function(){
					$(this).css("background","white");
					});

					$('.CustomDataBlock').live("click",WaitItemClickEvent);
			</script>
	</div>

	
	<div id="RightBlock">
		<div id="CustomItemListBlock">
		</div>
	</div>
	<div id="LeftBlock">
		<div id="NumberBlock">
			<select id="NumberSelector" style="font-size:20px;" multiple="1">
			</select>
		</div>
		<div id="StatusBlock">
			<div style="height:70%">
				<div style="font-size:25px;">目前號碼</div>
				<span id="NowValue" style="font-size:110px;">9999</span>
			</div>
			<!--
			<div style="height:15%;font-size:18px;">已抽號碼:<span id="Value">9999</span></div>
			<div style="height:15%;font-size:18px;">等候人數:<span id="WaitValue">9999</span></div>
			-->
		</div>
		<div id="ControlBlock">
			<table id="ControlBlockTable">
				<tr class="Tr" >
					<td class="Td" colspan="2">
						<button id="CallNumber" style="width:100%; height:100%; font-size:50px;">叫號</button>
					</td>		
				</tr>
				<tr class="Tr" >
					<td class="Td">
						<button id="CancelSelect" style="width:100%; height:100%; font-size:30px;">取消選取</button>
					</td>
					
					<td class="Td">
						<button id="EndNumber" style="width:101%; height:100%; font-size:30px;">結束服務</button>
					</td>
				
				</tr>
			</table>
		</div>
	</div>
	

</div>

<script>
$("#NumberSelector").change(function()
{	
	$(".ListBlock").css("background-color","white");
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
						
						//loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":$(this).val()});
						$('#Num'+$(this).val()).css("background-color","#AFEEEE");
						var newposition=$('#Num'+$(this).val()).offset().top;
						//alert(newposition);
						$('#CustomItemListBlock').scrollTop(newposition-166);
						
					});
	}
	if(Count==0)
	{	

		var Count=$(this).children().size();
		if(Count==1)
		{	
			$(this).children().each(function(){
						$(this).attr("selected",true);
						$('#Num'+$(this).val()).css("background-color","#AFEEEE");
						//loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":$(this).val()});
						
					});
		}

	}
});


$('#CallNumber').click(function()
		{	
			var Number=$('#NumberSelector').children("[selected]").val();
			
			if(Number!=undefined)
			{
				Type2NextValue(Number,'<?php echo $ItemID ?>');
			
			}
			else
			{
				/*
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
				else*/
					alert("請選取號碼");
				
			}
				
		});




$('#CancelSelect').click(function(){
	$('#NumberSelector').children().attr("selected",false);
	$('#CustomItemListBlock').children().each(function(){
					$(this).css("background-color","white");

				});
			
});



$('#EndNumber').click(function(){
$.ajax({
		type:'POST',
		url:'EndNumber.php',
		data:{},
		success:function(data){
		
			if(data=="-1")
			{
				alert("無法取得SerialNumber");
			}
			else if(data=="-2")
			{	
				alert("目前的號碼已結束");
			}
			else
			{
				//alert(data);
			}
			
			},
		dataType:"text"
		});



});


GetValue('<?php echo $ItemID ?>');
/*
$(function(){
	$("li:has(ul)").click(function(e){
		if(this==e.target){
			if($(this).children().is(":hidden"))
			{
				$(this).css("list-style-image","url(img/minus.gif)").children().show();
			}
			else
			{
				$(this).css("list-style-image","url(img/plus.gif)").children().hide();
			}

		}
		return false;

	}).css("cursor","pointer").click();
});*/
</script>

	
