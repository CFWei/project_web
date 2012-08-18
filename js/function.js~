
//控制ControlBar和scroll一起移動
$().ready(function() {  
 var $scrollingDiv = $("#ControlBar"); // #scrollingDiv請改成自己要移動的元素 
 $(window).scroll(function(){ 
  $scrollingDiv
   .stop()
   .animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );   
 });
});


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
	window.setTimeout('UpdateValue(\''+SerialNumbers+'\')', 2000);
	

}
function EditValue()
{

}


function loadpage(DivName,LoadPage)
{

	if(DivName=="#content"&&LoadPage=="managepage.php")
	{	
		
		$(DivName).load(LoadPage,function(){
			$('#ItemTable').hide();
			var heig=$('#ItemTable').height()+30;
			$("#content").animate({
					height:heig,
					width:"1050px",
					left:"3%",
				      },800,function(){$('#ItemTable').fadeIn(400);});
			
			});
		
	}

	else if(DivName=="#content"&&LoadPage=="add_item.php")
	{	
		
		$(DivName).load(LoadPage,function(){
			$('#AddItemContent').hide();
			$("#content").animate({
					height:"300px",
					width:"600px",
					left:"5%",
				      },800,function(){$('#AddItemContent').fadeIn(400);});
		});
	}
	else if(DivName=="#content"&&LoadPage=="login.php")
	{
		$(DivName).load(LoadPage,function(){
			$("#content").animate({
					height:"220px",
					width:"650px",
					left:"5%",
				      },800,function(){});
		});
	
	}
	else
	{	
		$(DivName).load(LoadPage);

	}

}

function RegisterContextMenu(SerialNumbers)
{
	$(".ItemBlock").contextMenu("myMenu1",{
				bindings: 
				{
					"delete":function(t)
						{
							DeleteItem(t.id,SerialNumbers);
						},
					"ItemFullScreen":function(t)
						{
							var wid=$('#content').width();
							var heig=$('#content').height();
							$('#'+t.id).animate({
										height:heig,
										width:wid,
										zIndex:"333"
							
										},800);
						}
						

				},
				});
}
function DeleteItem(ItemID,SerialNumbers)
{
	$('#content').load('DeleteItem.php',{"ItemID":ItemID,"SerialNumbers":SerialNumbers});
}



