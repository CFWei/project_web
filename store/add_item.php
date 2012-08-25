<?php	
	//-1:新增至mysql失敗 -2:有相同名稱的存在 1:成功

	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");

	$SerialNumbers=$_POST['SerialNumbers'];
	$Item_Name=$_POST['Item_Name'];
	
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	//確認有沒有相同名稱的產品已經存在
	$query="SELECT * FROM ".$SerialNumbers." WHERE Name ='".$Item_Name."' and State !='DIE'";
	$db->query($query);

	if($db->get_num_rows()!=0)
	{	
		echo "-2";
		exit ;
	}
	
	//產生新的ItemID
	$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
	$len = strlen($word);
	$item_id="";
	for($i=0;$i<10;$i++)
	{
		$item_id.=$word[rand() % $len];
	}


	$result=$db->query("INSERT INTO `".$SerialNumbers."`(`ID`,`Name`,`State`,`Value`,`Now_Value`) VALUES ('".$item_id."','".$Item_Name."','STOP','0','0')");
	

	
	if($result)
	{
		echo "1";
		exit;
	}

	else
	{

		echo "-1";


	}
?>
	
	
