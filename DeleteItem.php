<?php
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
require_once("session.php");

$se=new session();	

if(!$SerialNumbers=$se->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}	

$ItemID=$_POST['ItemID'];

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//$query="SELET FROM 'custom_information' where store ='".$SerialNumbers."' and item='".$ItemID."'";
$query="UPDATE custom_information SET life ='1' where store='".$SerialNumbers."' and item ='".$ItemID."'";
$db->query($query);

$query="UPDATE ".$SerialNumbers." SET State='DIE' where `ID`='".$ItemID."'";
$db->query($query);

?>
<script>
alert("刪除成功");
loadpage("#content","managepage.php");
</script>
