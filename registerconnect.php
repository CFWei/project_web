<?php
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

//連接資料庫
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

echo '<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">';

$insert_cloumn="";
$insert_value="";
//接收POST的VALUE
foreach($_POST as $column=>$value)
{
	//檢查是否有NULL的欄位
	if($value==NULL)
	{
		echo $column,"的值是NULL<br>";			
		exit;
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
}
else
	//echo "註冊失敗";

?>
