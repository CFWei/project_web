<?php
	require_once("session.php");
	$se=new session();
	$se->destroy();

	echo '<script>

		loadpage("#content","login.php");
		$("#ControlBar").html("");
		$("#ControlBar").animate({
					width:"0px",
					height:"0px",
					borderWidth:"0px"
				 },800);
	</script>';
	
?>

