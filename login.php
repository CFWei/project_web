<?php 
require_once("session.php");
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

echo '<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">';

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM store_information where `UserID` =  '".$_POST['ID']."' AND `UserPassword` ='".$_POST['passwd']."'";
$db->query($query);

if($db->get_num_rows()!=1)
{	
		echo "登入失敗!";
		header("Refresh: 1; url=\"index.html\"");
		exit;
}	
else
	echo "登入成功!";

$result=$db->fetch_array();


$se=new session();
$se->register_value("USERID",$_POST['ID']);
$se->register_value("SerialNumbers",$result['SerialNumbers']);
header("Location:manager.php");

?>