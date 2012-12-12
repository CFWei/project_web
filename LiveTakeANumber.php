<?php
require_once("session.php");
$session=new session();
if(!$SerialNumbers=$session->get_value("SerialNumbers"))
{
	echo "******************取得SerialNumbers失敗******************";
	exit();
}

if(!$StoreType=$session->get_value("StoreType"))
{
	echo "******************取得StoreType失敗******************";
	exit();
}


$ItemID=$_GET['ItemID'];

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");
$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$query="SELECT * FROM ".$SerialNumbers." WHERE ID='".$ItemID."' and State!='DIE'";
$db->query($query);
$Item=$db->fetch_array();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<link href="css/LiveTakeANumber.css" rel=stylesheet type="text/css" >
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	</head>
	<body>
		<div id="SerialNumbers" name="<?php echo $SerialNumbers; ?>"></div>
		<div id="LiveTakeANumberPage">
			<div class="Row">
				<div id="ItemName" name="<?php echo $ItemID; ?>" class="Col" style="height:10%; font-size:65px; background-color:#f00;">
					<?php echo $Item['Name'];?>
				</div>
			</div>
			<div class="Row">
				<div class="Col" style="height:20%;">
					<div id="InputScreen">
						<div class="Row">
							<div class="Col" style="height:20%; line-height:36px;">
								請輸入您的手機進行抽號	
							</div>
						</div>
						<div class="Row">
							<div class="Col" style="height:80%; line-height:148px; font-size:120px;">
								<span id>09</span><span id="CellPhoneNumber"></span>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="Row">
				<div class="Col" style="height:70%;">
					<div id="NumberSelector">
						<div class="Row">
							<div class="Col">
								<button class="SelectorButton" name="1">1</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="2">2</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="3">3</button>
							</div>
						</div>

						<div class="Row">
							<div class="Col">
								<button class="SelectorButton" name="4">4</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="5">5</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="6">6</button>
							</div>
						</div>
						
						<div class="Row">
							<div class="Col">
								<button class="SelectorButton" name="7">7</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="8">8</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="9">9</button>
							</div>
						</div>

						<div class="Row">
							<div class="Col">
								<button class="SelectorButton" name="delete">刪除</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="0">0</button>
							</div>
							<div class="Col">
								<button class="SelectorButton" name="Submit">送出</button>
							</div>
						</div>
					</div>
				</div>
			</div>					
		</div>
		<script>
			$('.SelectorButton').click(function(){
						var Number=$(this).attr("name");
						var cellPhoneLength=$('#CellPhoneNumber').html().length;
						if(cellPhoneLength>=8&&Number!="delete"&&Number!="Submit"){
							alert("已超過手機長度");
							return;
						}
						if(Number=="delete"){
							var value=$('#CellPhoneNumber').html().substring(0,cellPhoneLength-1);
							$('#CellPhoneNumber').html(value);
							return;
						}
						if(Number=="Submit"){
							var value=$('#CellPhoneNumber').html();
							var ItemID=$('#ItemName').attr("name");
							var SerialNumbers=$('#SerialNumbers').attr("name");
							if(value.length<8){
								alert("手機號碼長度不正確");
								return;
							}
							x=confirm("你的手機號碼為09"+value+"\n 確定要抽號嗎？");
							if(x){
								window.location.href="Type1TakeANumber.php?ItemID="+ItemID+"&SerialNumbers="+SerialNumbers+"&CellPhoneNumber=09"+value;		
							}

							return;
						}
						$('#CellPhoneNumber').append(Number);
						
					});
		</script>
	</body>
</html>
