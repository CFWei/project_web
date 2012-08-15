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
		header("Location:manager.php");
	}

}



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
<link rel=stylesheet type="text/css" href="style.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">

function gopage(choose)
{	


	if(choose==1)
	{
		document.getElementById('LoginBox').action="index.php";
		document.LoginBox.submit();	
	}
	if(choose==2)
	{	
		$('#content').animate({
				height:"60%"
			      },1500);
		$('#content').load('register.html');

		//document.getElementById('LoginBox').action="register.html";
		//document.LoginBox.submit();	
	}
	
}


</script>


</head>
<body>
<div id="main">
	<div id="header">
		<div id="title">
			TAKE A NUMBER SYSTEM
		</div>
	</div>

	<div id="content">

	</div>
	<script>
		$('#content').load('login.html')
	</script>
	<div id="footer">
		Copyright (c) 2012 Sitename.com. All rights reserved. Design by FCT.		
	</div>
</div>
</body>
</html>
