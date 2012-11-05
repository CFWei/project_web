<?php
//	<button class="controlbarbutton" id="ModifyInformation">修改資訊</button>
//	<button class="controlbarbutton" id="MyItem">我的商品</button>
//
//
require_once("session.php");
$session=new session();

if(!$StoreType=$session->get_value("StoreType"))
{
	echo "******************取得StoreType失敗******************";
	exit();
}

?>
<div id="controlbarcontent">
	<?php
		if($StoreType=="1")
		{
			echo 
			'
			<button class="controlbarbutton" id="additem">新增商品</button>
			<button class="controlbarbutton" id="Setting">設定</button>
			<button class="controlbarbutton" id="BackToManage">返回主頁</button>
			<button class="controlbarbutton" id="Logout">登出</button>
			';
		}

		if($StoreType=="2")
		{
			echo 
			'
			<button class="controlbarbutton" id="Setting" onclick="SettingButtonEvent()";>設定</button>
			<button class="controlbarbutton" onclick="self.location.href=\'FullScreen.php\'">全螢幕</button>
			<button class="controlbarbutton" id="BackToManage" onclick="BackToManageEvent()">返回主頁</button>
			<button class="controlbarbutton" id="EndBusiness">結束營業</button>
			<button class="controlbarbutton" id="Logout">登出</button>
			';
			
		}
	?>

</div>

<script>
	function SettingButtonEvent()
	{
		loadpage("#content","StoreSetting.php");
	};

	function BackToManageEvent()
	{
		loadpage("#content","managepage.php","<?php echo $StoreType ?>");
	};
		
	function EndBusinessEvent()
	{
		check=confirm("你確定要結束營業嗎?");
			if(check)
			{
				loadpage("#content","EndBusiness.php");
			}
	};

	function LogoutEvent()
	{
		loadpage("#content","logout.php");
	};


	$("#additem").click(function(){
				loadpage("#content","add_item.php");				
			});

	$('#BackToManage').click(
		function()
		{	
			loadpage("#content","managepage.php","<?php echo $StoreType ?>");
		});
	$('#ModifyInformation').click(
		function()
		{	
			loadpage("#content","ModifyStoreInformation.php");
		});
	$('#MyItem').click(
		function()
		{	
			loadpage("#content","MyItem.php");
		});
	$('#Setting').click(
		function(){
				loadpage("#content","StoreSetting.php");
			
			});

	$("#EndBusiness").click(
		function()
		{
			check=confirm("你確定要結束營業嗎?");
			if(check)
			{
				loadpage("#content","EndBusiness.php");
			}
		});
	


	$('#Logout').click(
		function()
		{	
			loadpage("#content","logout.php");
			$('#MenuBar').remove();
		});

</script>
