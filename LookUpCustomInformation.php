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

//$ID="ueuKJKpyMD";
//$store="5mrXWaA7wbYgindrQZmh";

$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$query="SELECT number,custom_id,life FROM custom_information WHERE store='".$SerialNumbers."' and item='".$ItemID."'";

$db->query($query);


?>
<div id ="LookUpCustomInformationTable">
	<div class="TableTr">
		<div class="TableTd">
		號碼
		</div>
		<div class="TableTd">
		使用者ID
		</div>
		<div class="TableTd">
		狀態
		</div>
	</div>

<?php
while(($temp=$db->fetch_assoc())!=null)
{
	echo '<div class="TableTr">';
	/***************************/
	echo '<div class="TableTd">';
	echo $temp['number'];
	echo '</div>';

	echo '<div class="TableTd">';
	echo $temp['custom_id'];
	echo '</div>';

	echo '<div class="TableTd">';
		if( $temp['life']=="0")
			echo "未服務";
		else if( $temp['life']=="1")
			echo "已服務";
		else
			echo "未定義";
	
	echo '</div>';
	/***************************/
	echo '</div>';
}

?>


<div>
