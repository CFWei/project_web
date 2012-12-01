<?php
	require_once("session.php");
	$se=new session();
	$se->destroy();

	echo '<script>

		loadpage("#content","login.php");
		$(".MenuBar").remove();
	</script>';
	
?>

