<?php
require_once("session.php");
$session=new session();

if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT ItemID,Quantity,GroupID FROM Type2".$SerialNumbers;
$db->query($query);

while($temp=$db->fetch_array())
{	
	echo $temp['ItemID']." ".$temp['Quantity'];
	echo "<button>完成</button>";
	echo "<br>";
}

?>
<script>
	
</script>
