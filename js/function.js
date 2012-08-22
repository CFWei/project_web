
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

function NextValue(Item_Id,choose)
{	
	$.post('next_value.php',
		{"Item_Id":Item_Id,"choose":choose},
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
function UpdateValue()
{
	var ItemBlock=document.getElementsByClassName("ItemBlock");
	for(var i=0;i<ItemBlock.length;i++)
	{
		 var Item_Id=ItemBlock[i].id;
		
		 $.post('updatevalue.php',
		 	{"Item_Id":Item_Id},
			function(data)
			{	

				if($("#"+data.Item_Id+" .WaiNumValue").html()!=data.WaiNumValue)
					$("#"+data.Item_Id+" .WaiNumValue").html(data.WaiNumValue);
							
				if($("#"+data.Item_Id+" .TakenNumValue").html()!=data.Value)
					$("#"+data.Item_Id+" .TakenNumValue").html(data.Value);	
				if($("#"+data.Item_Id+" .NowValue").html()!=data.Now_Value)
				$("#"+data.Item_Id+" .NowValue").html(data.Now_Value);

				if(data.State=="WAIT")
					{
						NextValue(data.Item_Id,3);
					}
				 
			},
			"json"
		 	);
		
		
	}
	window.setTimeout('UpdateValue()', 2000);
	

}
function EditValue(ItemID)
{
var txt = '請輸入要跳的號碼:<br /><input type="text" name="EditValue"}" />';



$.prompt(txt,{
	callback:function(e,v,m,f)
		{
			if(v=="Submit"&&f.EditValue!="")
			{
				 $.post('EditNum.php',
					{"ItemID":ItemID,"EditValue":f.EditValue},
					function(data)
					{
						if(data=="-1")
							alert("沒有這個號碼的顧客");
						if(data=="-2")
							alert("無法取得SerialNumbers");
						if(data=="-3")
							alert("輸入的不是數字");
						if(data==f.EditValue)
						{
							//alert("跳號成功");
							$("#"+ItemID+" .NowValue").html(data);
						}
					},
					"text");
			}
			
			
		},
	buttons: { 確認: 'Submit', 取消: 'Cancel' },
	prefix:'cleanblue',
	focus: 0,
	show:'slideDown'
	});

}




function loadpage(DivName,LoadPage,parameter)
{

	if(DivName=="#content"&&LoadPage=="managepage.php")
	{	
		
		$(DivName).load(LoadPage,function(){
			$('#ItemTable').hide();
			var heig=$('#ItemTable').height()+30;
			
			
			$("#content").animate({
					height:heig, 
					width:"903px",
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
	else if(DivName=="#content"&&LoadPage=="LookUpCustomInformation.php")
	{
		$(DivName).load(LoadPage,{ 'ItemID':parameter.ItemID,'selector':parameter.selector},function(){
					
			var heig=$('#LookUpCustomInformationTable').height()+60;
			$("#content").animate({
					height:heig,
					width:"550px",
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
							DeleteItem(t.id);
						},
					"ItemFullScreen":function(t)
						{
							var wid=$('#content').width();
							var heig=$('#content').height();
							/*
								$('#'+t.id).animate({
										height:heig,
										width:wid,
										zIndex:"333"
							
										},800);
							*/
						}
						

				},
				});
}
function DeleteItem(ItemID)
{
	$('#content').load('DeleteItem.php',{"ItemID":ItemID});
}
function LookUpCustomInformation(ItemID)
{
	loadpage("#content","LookUpCustomInformation.php",{"ItemID":ItemID});
}
function LookUpCustomInformationSelector(ItemID)
{
	var selector=document.SelectorForm.Selector.value;
	loadpage("#content","LookUpCustomInformation.php",{"ItemID":ItemID,"selector":selector});
}

