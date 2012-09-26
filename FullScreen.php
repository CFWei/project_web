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

$query="Select StoreName FROM store_information WHERE SerialNumbers ='".$SerialNumbers."'";
$db->query($query);
$temp=$db->fetch_array();
$StoreName=$temp['StoreName'];


$query="SELECT * FROM ".$SerialNumbers." WHERE State !='DIE'";
$db->query($query);
if($db->get_num_rows()==0)
{	

	echo "<script> alert('你尚未開始營業'); </script>";
	header("Refresh: 0; url='index.php'");	
	exit;
}


$temp=$db->fetch_array();
$NowValue=$temp['Now_Value'];

$ItemID=$temp['ID'];
$Value=$temp[''];
?>
<head>
	<script type="text/javascript" src="js/function.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="js/jquery.alerts.js"></script>
	<script type="text/javascript" src="js/contextmenu.js"></script>
	<script type="text/javascript" src="js/jquery-impromptu.4.0.js"></script>
	<link href="css/imprompt.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="css/style.css" rel=stylesheet type="text/css" >
</head>

<body>
	<div id="FullScreen">
		<div id="StoreNameColumn">
			<?php echo $StoreName; ?>
		</div>

		<div id="ItemInformation">
			<span id="FullScreenNowValue"><?php echo $NowValue; ?></span>

		</div>

		<div id="OtherContent">
			等候人數: <span id="FullScreenWaitValue"></span>
			<span id="ValueSpan">已抽號碼: <span id="FullScreenValue"></span></span>
		</div>
		<div>
			<button style="width:10%; height:5%; font-size:20px;" onclick="location.href='index.php'">上一頁</button>
		</div>
	</div>
	<script>
		FullScreenUpdateValue('<?php echo $ItemID; ?>');
	</script>
</body>
