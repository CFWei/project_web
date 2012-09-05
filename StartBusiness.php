<?php
//-1:無法取得SerialNumbers
//-2:已經開始營業

require_once("session.php");
$se=new session();

if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "-1";
	exit();
}

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE' ";
$db->query($query);

if($db->get_num_rows()!=0)
{
	echo "-2";
	exit;
}

/*產生新的Item的key*/
$word ='abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';//樣本
$len = strlen($word);
$item_id="";

for($i=0;$i<10;$i++)
{
	$item_id.=$word[rand() % $len];
}

$query="INSERT INTO `".$SerialNumbers."`(`ID`,`Name`,`State`,`Value`,`Now_Value`) VALUES ('".$item_id."','TYPE2','STOP','0','0')";
$db->query($query);

echo '1';

?>
