<html>
<head>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
function codeAddress()
	{	
		var geocoder;
		var address="高雄縣大社鄉神農村";
		geocoder= new google.maps.Geocoder();
		var choose = document.getElementById('choose');
		geocoder.geocode({'address':address},function(results,status)
		{
			if(status==google.maps.GeocoderStatus.OK)
				{	
					choose.innerHTML=results[0].geometry.location.lat();
					document.write(results[0].geometry.location.lng());
					
				}

			else
				{
					document.write("fail");
					alert("Geocode was not successful for the following reason: " + status);
				}

		});
	}
</script>
</head>


<body>
<div id="choose">test</div>

<?php
	//$address=$_POST['address'];
	echo '<script type="text/javascript">';
	echo "codeAddress(\"".$address."\");";
	echo '</script>';
	
?>


</body>

</html>
