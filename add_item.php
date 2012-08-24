<?php
if(isset($_POST['Item_Name']))
{	
	require_once("connect_mysql_class.php");
	require_once("mysql_inc.php");
	require_once("session.php");
	$se=new session();	
	if(!$SerialNumbers=$se->get_value("SerialNumbers"))
	{
		echo "******************取得SerialNumbers失敗******************";
		exit();
	}

	$Item_Name=$_POST['Item_Name'];

	$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
	$len = strlen($word);
	$item_id="";
	for($i=0;$i<10;$i++)
	{
		$item_id.=$word[rand() % $len];
	}
	
	
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	$query="SELECT * FROM ".$SerialNumbers." WHERE Name ='".$Item_Name."' and State !='DIE'";
	$db->query($query);

	if($db->get_num_rows()!=0)
	{	

		if(isset($_POST['Choose']))
				{	
					echo "-2";
					exit;
				}	
		echo "已有相同名稱商品";
		exit;
	}


	$result=$db->query("INSERT INTO `".$SerialNumbers."`(`ID`,`Name`,`State`,`Value`,`Now_Value`) VALUES ('".$item_id."','".$Item_Name."','STOP','0','0')");
	if($result)
		{	
			if(isset($_POST['Choose']))
				{	
					echo "1";
					exit;
				}				
			echo '<script>';
			echo 'loadpage("#content","managepage.php");';
			//echo 'alert("新增商品成功");';
			echo '</script>';
			$content="新增商品成功";

			exit;
		}
	else
		{	
			if(isset($_POST['Choose']))
				{	
					echo "-1";				
					exit;
				}
			$content="新增商品失敗";
		}
}



?>

<div id="AddItemContent">
	<h1>新增商品</h1>
	<?php echo $content; ?>
	<form method="post" action="">
		名稱:<input id="AddItemName" type="text" name="Item_Name">
	</form>
	<button id="AddItemButton">送出</button>
</div>
<script>
$('#AddItemButton').click(
			function()
			{	
				var Item_Name=$('#AddItemName').val();
				$('#content').load('add_item.php',{"Item_Name":Item_Name});
				//$('#content').load('login.php',{"ID":ID,"PASSWD":PASSWD});
			});
</script>
<HR>
