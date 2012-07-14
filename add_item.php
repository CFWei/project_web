<?php 
echo '<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">';
include("session_check.php");


if(isset($_POST["Item_Name"]))
{
	require_once("connect_mysql_class.php");
	require_once("mysql_inc.php");

	$SerialNumbers=$se->get_value("SerialNumbers");
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
	$result=$db->query("INSERT INTO `".$SerialNumbers."`(`ID`,`Name`,`State`,`Value`,`Now_Value`) VALUES ('".$item_id."','".$Item_Name."','STOP','0','0')");
	if($result)
		{
			echo "新增商品成功";
			header("Refresh: 1; url=\"manager.php\"");
			exit;
		}
	else
		{
			echo "新增商品失敗";
		}
}


?>

<head>
</head>
<body>
<form method="post" action="add_item.php">
	名稱:<input type="text" name="Item_Name">
	<input type="submit" value="送出">
</form>
</body>