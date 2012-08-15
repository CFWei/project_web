
//login.html的選擇器
function gopage(choose)
{	
	if(choose==1)
	{	
		alert("登入");
	}
	if(choose==2)
	{	
		$('#content').animate({
				height:"58%"
			      },800);
		$('#content').load('register.php');	
	}
	
}

//register.html的地址轉經緯度程式
function codeAddress()
{	
	var geocoder;
	geocoder= new google.maps.Geocoder();
	var address=document.getElementById("StoreAddress").value;
	geocoder.geocode({'address':address},
	function(results,status)
	{
		if(status==google.maps.GeocoderStatus.OK)
		{	
			document.getElementById("GPS_Latitude").value=results[0].geometry.location.lat();
			document.getElementById("GPS_Longitude").value=results[0].geometry.location.lng();
		}
		else
		{
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
			
	
}


