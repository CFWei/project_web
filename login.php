<?php
$content="";
$ID=$_POST['ID'];
$PASSWD=$_POST['PASSWD'];
if($ID!=""&&$PASSWD!="")
{	
	require_once("session.php");
	require_once("connect_mysql_class.php");
	require_once("mysql_inc.php");	
	$content="123";
	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="SELECT * FROM store_information where `UserID` =  '".$ID."' AND `UserPassword` ='".$PASSWD."'";
	$db->query($query);

	if($db->get_num_rows()!=1)
	{	
		$content="登入失敗";
	}
	else
	{
		$result=$db->fetch_array();
		$se=new session();
		$se->register_value("USERID",$_POST['ID']);
		$se->register_value("SerialNumbers",$result['SerialNumbers']);
		$content="登入成功";
		echo '<script>
			$("#content").animate({
				height:"500px",
				width:"1000px",
				left:"3%",
			      },800);
		$("#content").load("managepage.php");
		$("#ControlBar").animate({
					width:"120px",
					height:"300px",
					borderWidth:"5px"
				 },800);
		$("#ControlBar").load("controlbar.html");
		</script>';	
		exit;		
		//header("Location:manager.php");
	}

}

?>

<div id="centerbox" class="ContentStyle">
	<div id="hint">
		<?php
			echo $content;
		?>
	</div>
	<div id=CenterContent">
		<form id="LoginBox" method="post" action="">
			<div>
				<p>帳號:<input type="text" class="LoginTextArea" id="ID"></p>
				<p>密碼:<input type="password" class="LoginTextArea" id="PASSWD"></p>
			</div>
		</form>
		<button id="LoginButton" class="ButtonStyle" >登入</button>
		<button id="RegisterButton" class="ButtonStyle" onclick="javascript:gopage(2)">註冊</button>	
		<script>
			$('#LoginButton').click(
			function()
			{	
				var ID=$('#ID').val();
				var PASSWD=$('#PASSWD').val();
				$('#content').load('login.php',{"ID":ID,"PASSWD":PASSWD});
			});
		</script>
	</div>
</div>

