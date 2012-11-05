
<html>
<head>
<title>Take A Number</title>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
<link href="css/style.css" rel=stylesheet type="text/css" >
<link href="css/imprompt.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.alerts.js"></script>
<script type="text/javascript" src="js/contextmenu.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/jquery-impromptu.4.0.js"></script>
</head>
<body id="IndexPage">
<div id="main">
	<div id="header">
		<div id="title">
			TAKE A NUMBER SYSTEM
		</div>
	</div>

	<div id="content">

	</div>
	<script>
		$('#content').load('login.php');
		//$('#content').load('managepage.php');
	</script>
	<div id="footer">
		Copyright (c) 2012 Sitename.com. All rights reserved. Design by CFWei.		
	</div>
	
</div>
<script>
	FullScreenUpdateValue();
					
			$('#MenuBar').hover(function(){
					
					$(this).height("205px");
					loadpage('#MenuBar',"controlbar.php");
				},function(){
				
					$(this).height("30px");
					$(this).html('<span style="font-size:30px;">選單</span>');
					});
</script>
</body>
</html>
