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



if(isset($_POST['ItemName'])&&isset($_POST['Group'])&&$_POST['Group']!=""&&$_POST['ItemName']!="")
{	
	
	if($_POST['Choose']=="1")
	{	
		$query="DELETE FROM `StoreItemList` WHERE SerialNumbers='".$SerialNumbers."' and ItemName ='".$_POST['ItemName']."' and `Group` ='".$_POST['Group']."'";
		$db->query($query);
		exit;

	}
	else
		$db->query("INSERT INTO `StoreItemList` (`SerialNumbers`,`ItemName`,`Group`) VALUES ('".$SerialNumbers."','".$_POST['ItemName']."','".$_POST['Group']."')");
}




if(isset($_POST['Category']))
	{
		$query="SELECT * FROM StoreItemList WHERE SerialNumbers = '".$SerialNumbers."' and `Group`='".$_POST['Category']."'";
		$Selectcontent[(int)$_POST['Category']]="selected";
	}
else
	$query="SELECT * FROM StoreItemList WHERE SerialNumbers = '".$SerialNumbers."'";

$db->query($query);


?>
<div id="MyItemDiv">
<div>
	<form name="SelectorForm">                                                                           
		<select name="Selector" onchange="MyItemSelector()" >
			<option value=0  <?php echo $Selectcontent[0] ?>>全部
			<option value=1  <?php echo $Selectcontent[1] ?>>群組一
			<option value=2  <?php echo $Selectcontent[2] ?>>群組二
			<option value=3  <?php echo $Selectcontent[3] ?>>群組三
		</select>		                                                              
                                                               
	</form>    
</div>

<div id ="MyItemTable">
	<div class="MyItemTableTr">
		<div class="MyItemTableTd">
			選項
		</div>
		<div class="MyItemTableTd">	
			商品名稱
		</div>
		<div class="MyItemTableTd">	
			Group
		</div>
	</div>
<?php

while(($temp=$db->fetch_assoc())!=null)
{

	
	echo '<div class="MyItemTableTr">';
		echo '<div class="MyItemTableTd">
			<input class="SelectCheckBox" type="checkbox">
		      </div>';
		echo '<div class="MyItemTableTd">';
		echo '<span class="MyItemName">';
			echo $temp['ItemName'];
		echo '</span>';
		echo '</div>';
		echo '<div class="MyItemTableTd">';
		echo '<span class="MyItemGroup">';
			if($temp['Group']=="1")
				echo "群組一";
			if($temp['Group']=="2")
				echo "群組二";
			if($temp['Group']=="3")
				echo "群組三";
		echo '</span>';
		echo '</div>';
	echo '</div>';
	
}


?>
</div>
<button id="AllChoose">全選</button>
<br>
<button id="AddChooseItem">新增選取商品</button>
<button id="DeleteChooseItem">刪除選取商品</button>


<HR>
<div id="AddMyItem">
	<h1>新增商品</h1>
	<form method="post" action="">
		名稱:<input id="AddMyItemName" type="text" name="ItemName">
		<select id="GroupSelector" >
			<option value=1>群組一
			<option value=2>群組二
			<option value=3>群組三
		</select>		
	</form>
	<button id="AddMyItemButton">送出</button>
</div>

<script>
$('#AllChoose').click(function(){
		$(".SelectCheckBox").each(function(){
				$(this).attr("checked",true);
			});

		});
$('#AddMyItemButton').click(
			function()
			{	
				var Group=$("#GroupSelector").val();
				var ItemName=$('#AddMyItemName').val();
				if(ItemName!="")
				{				
					$('#content').load('MyItem.php',{"ItemName":ItemName,"Group":Group},
							function(){
							var height=$('#MyItemDiv').height();			
							$("#content").animate({
									height:height,
									width:"550px",
									left:"5%",
							      		},800,function(){});});
				}
			});
$('#DeleteChooseItem').click(
			function()
			{	
			
				
				var count=0;
				for(var i=0;i<$('.SelectCheckBox').length;i++)
				{	
					if($('.SelectCheckBox').eq(i).attr('checked'))
					{
						var ItemName=$('.SelectCheckBox').eq(i).parent().parent().children('.MyItemTableTd').children('.MyItemName').html();
						var Group=$('.SelectCheckBox').eq(i).parent().parent().children('.MyItemTableTd').children('.MyItemGroup').html();			
						var sendgroup=0;
						if(Group=="群組一")
							sendgroup=1;
						if(Group=="群組二")
							sendgroup=2;
						if(Group=="群組三")
							sendgroup=3;
						$.post("MyItem.php",{"ItemName":ItemName,"Group":sendgroup,"Choose":"1"},function(data){},"txt");
					
					}
				}
					$('#content').load('MyItem.php',{},
							function(){
							var height=$('#MyItemDiv').height();			
							$("#content").animate({
									height:height,
									width:"550px",
									left:"5%",
							      		},800,function(){});});
			
			});
$('#AddChooseItem').click(
			function()
			{	
				var count=0;
				for(var i=0;i<$('.SelectCheckBox').length;i++)
				{	
					if($('.SelectCheckBox').eq(i).attr('checked'))
					{
						var ItemName=$('.SelectCheckBox').eq(i).parent().parent().children('.MyItemTableTd').children('.MyItemName').html();
						$.post("add_item.php",{"Item_Name":ItemName,"Choose":"1"},function(data){alert('123');},"txt");
					}
				}

				alert("新增完畢");
				$('#content').load('MyItem.php',{},
							function(){
							var height=$('#MyItemDiv').height();			
							$("#content").animate({
									height:height,
									width:"550px",
									left:"5%",
							      		},800,function(){});});
			});
</script>
</div>
