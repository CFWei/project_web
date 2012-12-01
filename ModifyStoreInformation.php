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

if(count($_POST)==5)
{



	$StoreName=$_POST['StoreName'];
	$StoreAddress=$_POST['StoreAddress'];
	$StoreTelephone=$_POST['StoreTelephone'];
	$GPS_Longitude=$_POST['GPS_Longitude'];
	$GPS_Latitude=$_POST['GPS_Latitude'];

	
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="UPDATE `store_information` SET `StoreName`=\"".$StoreName."\",`StoreAddress`=\"".$StoreAddress."\",`StoreTelephone`=\"".$StoreTelephone."\",`GPS_Longitude`=\"".$GPS_Longitude."\",`GPS_Latitude` =\"".$GPS_Latitude."\" where `SerialNumbers` =\"".$SerialNumbers."\"";
	$db->query($query);
	echo '<script>';
	echo 'loadpage("#content","managepage.php");';
	echo '</script>';
	exit();
}
else
{
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="SELECT StoreName,StoreAddress,StoreTelephone,GPS_Longitude,GPS_Latitude FROM store_information  where SerialNumbers='".$SerialNumbers."'";


	$db->query($query);
	$temp=$db->fetch_assoc();
}


?>
<div id="RegisterPage">
	<div id="RegisterTitle">修改資料</div>
		<form method="post" action="">
				<p><div class="RegisterText">店家名稱：</div><input type="text" class="RegisterTextArea" id="StoreName" maxlength="100" value="<?php echo $temp['StoreName']; ?>"></p>
				<p><div class="RegisterText">店家電話：</div><input type="text" class="RegisterTextArea" id="StoreTelephone"  maxlength="100" value="<?php echo $temp['StoreTelephone']; ?>" ></p>
				<p><div class="RegisterText">店家地址：</div><input type="text" class="RegisterTextArea" id="StoreAddress" name="StoreAddress" size="50" maxlength="100" onchange="codeAddress()" value="<?php echo $temp['StoreAddress']; ?>" ></p>
				<p>
				<div class="RegisterText" style="width:100px;">經度：</div><input type="text" class="RegisterTextArea" name="GPS_Latitude" id="GPS_Latitude" value="<?php echo $temp['GPS_Latitude']; ?>" style="width:200px;"> 
				<a style="font-size:28px;">緯度：</a><input type="text" class="RegisterTextArea" name="GPS_Longitude" id="GPS_Longitude" value="<?php echo $temp['GPS_Longitude']; ?>" style="width:200px;">
				</p>	
		</form>
		<button id="ModifySubmitButton" class="ButtonStyle" >修改</button>
		<button id="BackButton" class="ButtonStyle" >返回</button>
	</div>
</div>
<script>
	$('#ModifySubmitButton').click(
			function()
			{	
				var StoreName=$('#StoreName').val();
				var StoreTelephone=$('#StoreTelephone').val();
				var StoreAddress=$('#StoreAddress').val();
				var GPS_Latitude=$('#GPS_Latitude').val();
				var GPS_Longitude=$('#GPS_Longitude').val();
				
				$('#content').load('ModifyStoreInformation.php',
						{
						"StoreName":StoreName,"StoreTelephone":StoreTelephone,
						"StoreAddress":StoreAddress,"GPS_Latitude":GPS_Latitude,
						"GPS_Longitude":GPS_Longitude										
						});	
				
			});
	$('#BackButton').click(function(){
		loadpage("#content","managepage.php","<?php echo $StoreType ?>");
	});
</script>


