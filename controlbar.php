<div id="controlbarcontent">
	<button class="controlbarbutton" id="additem">新增商品</button>
	<button class="controlbarbutton" id="ModifyInformation">修改資訊</button>
	<button class="controlbarbutton" id="MyItem">我的商品</button>
	<button class="controlbarbutton" id="BackToManage">返回主頁</button>
	<button class="controlbarbutton" id="Logout">登出</button>
</div>

<script>
	$("#additem").click(function(){
				loadpage("#content","add_item.php");				
			});
	
	$('#BackToManage').click(
		function()
		{	
			loadpage("#content","managepage.php");
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
	$('#Logout').click(
		function()
		{	
			loadpage("#content","logout.php");
		});

</script>
