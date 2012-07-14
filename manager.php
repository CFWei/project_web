<?php 
require_once("session.php");
require_once("connect_mysql_class.php");
require_once("mysql_inc.php");

$session=new session();

if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "取得SerialNumbers失敗";
	exit();
}
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$query="SELECT * FROM ".$SerialNumbers;
$db->query($query);

echo '<button onclick="location=\'add_item.php\'">新增物品</button><br>';	


$num_of_item=1;
while($store_data=$db->fetch_array())
{	
	echo $num_of_item."<br>";
	$num_of_item++;
	foreach($store_data as $col=>$val)
		{ 
			echo $col.':'.$val."<br>";
		}
	
	$parameter="SerialNumber=".$SerialNumbers."&Item_Id=".$store_data['ID']."&State=".$store_data['State'];
	echo '<button onclick="location=\'change_state.php?'.$parameter.'\'">change_state</button>';
	echo "<br>========================<br>"	;
}

	


	?>
