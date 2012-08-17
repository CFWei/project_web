
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

function NextValue(SerialNumbers,Item_Id,choose)
{	
	$.post('next_value.php',
		{"SerialNumbers":SerialNumbers,"Item_Id":Item_Id,"choose":choose},
		function(data)
		{	
			if(data==(-1))
			{
				//alert("wait!!");
			}
			else
			{
				$('#'+Item_Id+' .InformationBlock .NowValue').html(data);
			}
			
		},
		"text"
		);

}
function UpdateValue(SerialNumbers)
{
	var ItemBlock=document.getElementsByClassName("ItemBlock");
	for(var i=0;i<ItemBlock.length;i++)
	{
		 var Item_Id=ItemBlock[i].id;
		 
		 $.post('updatevalue.php',
		 	{"SerialNumbers":SerialNumbers,"Item_Id":Item_Id},
			function(data)
			{	

				if($("#"+data.Item_Id+" .WaiNumValue").html()!=data.WaiNumValue)
					$("#"+data.Item_Id+" .WaiNumValue").html(data.WaiNumValue);
							
				if($("#"+data.Item_Id+" .TakenNumValue").html()!=data.Value)
					$("#"+data.Item_Id+" .TakenNumValue").html(data.Value);	
				if($("#"+data.Item_Id+" .NowValue").html()!=data.Now_Value)
					$("#"+data.Item_Id+" .NowValue").html(data.Now_Value);
				 
			},
			"json"
		 	);
		
	}
	window.setInterval('UpdateValue(\''+SerialNumbers+'\')', 2000);
	

}
