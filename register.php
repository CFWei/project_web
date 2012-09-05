<?php
	if(count($_POST)>0)
	{
		require_once("connect_mysql_class.php");
		require_once("mysql_inc.php");
		//連接資料庫
		$db=new DB();
		$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

		echo '<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">';

		$insert_cloumn="";
		$insert_value="";
		$check=0;
		//接收POST的VALUE
		foreach($_POST as $column=>$value)
		{
			//檢查是否有NULL的欄位
			if($value==NULL)
			{
				$content=$column."的值是NULL<br>";
				$check=1;			
				break;
			}
	
			//若不是第一個值則要加上逗號區隔
			if(strlen($insert_cloumn)!=0)
			{
				$insert_cloumn.=",";
				$insert_value.=",";
			}
	
			//將值串接上去
			$insert_cloumn.="`".$column."`";
			$insert_value.="'".$value."'";
		}
		
		if($check==0)
		{
			//產生SerialNumbers
			$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
			$len = strlen($word);
			$SerialNumbers="";
			for($i=0;$i<20;$i++)
			{
				$SerialNumbers.=$word[rand() % $len];
			}

			//將SerialNumbers加入到$insert_value和$insert_cloumn
			$insert_cloumn.=",`SerialNumbers`";
			$insert_value.=",'".$SerialNumbers."'";

			$result=$db->query('INSERT INTO `store_information`('.$insert_cloumn.') VALUES ('.$insert_value.')');

			$data=array("ID varchar(20)","Name varchar(30)","State varchar(20)","Value int(255)","Now_Value int(255)");
			$db->create_table($SerialNumbers,$data);

			if($result)
			{
				//echo"註冊成功";
				//header("Refresh: 1; url=\"index.html\"");
					echo '<script>
					     $("#content").animate({
							height:"220px"
						      },800);
						$("#content").load("login.php")</script>';	
					exit;
				
			}
			else
				$content="註冊失敗";
		}

	
		
	}

?>


<div id="RegisterPage">
	<div id="RegisterTitle">註冊資料</div>
	<div id=RegisterHint>
	<?php
		echo $content;
	?>
	</div>
	<form method="post" action="register.php">
		<p><div class="RegisterText">帳號：</div><input type="text" class="RegisterTextArea"  id="UserID" name="UserID" maxlength="20"></p>
		<p><div class="RegisterText">密碼：</div><input type="password" class="RegisterTextArea" id="UserPassword" name="UserPassword" maxlength="20"></p>
		<p><div class="RegisterText">店家名稱：</div><input type="text" class="RegisterTextArea" id="StoreName" name="StoreName" maxlength="100"></p>
		<p><div class="RegisterText">店家電話：</div><input type="text" class="RegisterTextArea"  id="StoreTelephone" name="StoreTelephone"  maxlength="100" ></p>	
		<p><div class="RegisterText">店家型態：</div>
		<select name="StoreType" id="StoreType">
			<option value=1  >1
			<option value=2  >2
		</select>
		</p>
		<p><div class="RegisterText">店家地址：</div><input type="text" class="RegisterTextArea" id="StoreAddress" name="StoreAddress" size="50" maxlength="100" onchange="codeAddress()"></p>
		<p>
		<div class="RegisterText">經度：</div><input type="text" class="RegisterTextArea" name="GPS_Latitude" id="GPS_Latitude" > 
		<a>緯度：</a><input type="text" class="RegisterTextArea" name="GPS_Longitude" id="GPS_Longitude" >
		</p>	
	</form>
	<button id="RegisterSubmitButton" class="ButtonStyle" >註冊</button>
	<button id="BackToLoginPageButton" class="ButtonStyle" >返回</button>
	<script>
			$('#RegisterSubmitButton').click(
			function()
			{	
				var UserID=$('#UserID').val();
				var UserPassword=$('#UserPassword').val();
				var StoreName=$('#StoreName').val();
				var StoreTelephone=$('#StoreTelephone').val();
				var StoreAddress=$('#StoreAddress').val();
				var GPS_Latitude=$('#GPS_Latitude').val();
				var GPS_Longitude=$('#GPS_Longitude').val();
				var StoreType=$('#StoreType').val();

				$('#content').load('register.php',
						{"UserID":UserID,"UserPassword":UserPassword,
						"StoreName":StoreName,"StoreTelephone":StoreTelephone,
						"StoreAddress":StoreAddress,"GPS_Latitude":GPS_Latitude,
						"GPS_Longitude":GPS_Longitude,"StoreType":StoreType										
						});	

			});

			$('#BackToLoginPageButton').click(function(){
								loadpage("#content","login.php");
							});
	</script>
</div>

