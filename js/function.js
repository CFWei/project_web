
//控制ControlBar和scroll一起移動
/*
$().ready(function() {  
 var $scrollingDiv = $("#ControlBar"); // #scrollingDiv請改成自己要移動的元素 
 $(window).scroll(function(){ 
  $scrollingDiv
   .stop()
   .animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );   
 });
});
*/

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
				alert("wait!!");
				
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
		 	{"Item_Id":Item_Id,"Type":"1"},
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
			var wid="95%";
			if(parameter=="1")
			
				var heig=$('#ItemTable').height()+30;
				
			if(parameter=="2")
				{	
					var heig=$('#Type2Block').height()+50;
					if(heig=="30")
					{
						heig="120";
						wid="50%";
					}
					wid="99%";
					heig="79%";
				}
			
			$("#content").animate({
					height:heig, 
					width:wid,
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
	else if(DivName=="#content"&&LoadPage=="ModifyStoreInformation.php")
	{
		$(DivName).load(LoadPage,{},function(){
					
			$("#content").animate({
					height:"500px",
					width:"98%",
					left:"5%",
				      },800,function(){});
					
					});
	}
	else if(DivName=="#content"&&LoadPage=="MyItem.php")
	{
		$(DivName).load(LoadPage,{},function(){
			var height=$('#MyItemDiv').height();			
			$("#content").animate({
					height:height,
					width:"550px",
					left:"5%",
				      },800,function(){});
					
					});
	}
	else if(DivName=="#CustomItemListBlock"&&LoadPage=="ChooseCustomItem.php")
	{	
		$(DivName).load(LoadPage,{"CustomNumber":parameter.CustomNumber});
	}
	else if(DivName=="#content"&&LoadPage=="StoreTakenItemList.php")
	{
		$(DivName).load(LoadPage,{},function(){
					
			var heig=$('#StoreItemListTable').height()+60;
			$("#content").animate({
					height:heig,
					width:"800px",
				      },800,function(){});
					
					});
	

	}
	else if(DivName=="#content"&&LoadPage=="StoreSetting.php")
	{
		$(DivName).load(LoadPage,{},function(){
					
			$("#content").animate({
					height:"300px",
					width:"800px",
				      },800,function(){});
					
					});
	}
	else if(DivName=="#content"&&LoadPage=="WaitItemModeList.php")
	{
		$(DivName).load(LoadPage,{"ItemID":parameter});
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
						},
					"OneItemScreen":function(t)
						{	
							OneItemScreen(t.id);
							
						},
					"LiveTakeNumber":function(t){
							LiveTakeNumber(t.id);
						}
						

				},
				});
}
function DeleteItem(ItemID)
{
	$('#content').load('DeleteItem.php',{"ItemID":ItemID});
}
function OneItemScreen(ItemID)
{
	$('#content').animate({
				height:"80%",
				width:"100%",			
				},800);
	$('#content').load('OneItemScreen.php',{"ItemID":ItemID});
}
function LiveTakeNumber(ItemID)
{
	window.open("LiveTakeANumber.php?ItemID="+ItemID);
}
function LookUpCustomInformation(ItemID)
{
	//loadpage("#content","LookUpCustomInformation.php",{"ItemID":ItemID});
	window.open('LookUpCustomInformation.php?ItemID='+ItemID,"123",config='height=300,width=400,toolbar=no,menubar=no,location=no,resizable=no ');

}
/*
function LookUpCustomInformationSelector(ItemID)
{
	var selector=document.SelectorForm.Selector.value;
	loadpage("#content","LookUpCustomInformation.php",{"ItemID":ItemID,"selector":selector});
}
*/
function MyItemSelector()
{
	var selector=document.SelectorForm.Selector.value;
	$("#content").load("MyItem.php",{"Category":selector},function(){
			var height=$('#MyItemDiv').height();			
			$("#content").animate({
					height:height,
					width:"550px",
					left:"5%",
				      },800,function(){});
					
					});
}

function StartBusiness()
{	
	/*
	$.post('StartBusiness.php',
			function(data)
			{
				alert("123");
			},
			"txt");
	*/
	$.ajax({
		  type: 'POST',
		  url: 'StartBusiness.php',
		  statusCode:{
				200:function(){
					loadpage("#content","managepage.php","2");
						;}
				},
		  dataType: "txt"
});


}


function GetValue(Item_Id)
{	
	/*
	$.post('updatevalue.php',
		 	{"Item_Id":Item_Id,"Type":"2"},
			function(data)
			{},
			"json");
	*/
	var c=1;
	//更新value清單
	$.ajax({
		  type: 'POST',
		  url: 'updatevalue.php',
		  data: {"Item_Id":Item_Id,"Type":"2"},
		  statusCode:{
				200:function(data){
						
						
						var NumberSelector=$('#NumberSelector');

						

						if(data.WaitCustomValue!=-1)
						{
							for(i=0;i<data.WaitCustomValue.length;i++)
							{
								var Number=NumberSelector.children("option[value='"+data.WaitCustomValue[i].number+"']").size();
							
								if(Number==0)
								{	
									
									NumberSelector.append(new Option(data.WaitCustomValue[i].number+"號"+"("+data.WaitCustomValue[i].TotalCost+"元)", data.WaitCustomValue[i].number, false, false));
									UpdateCustomList(data.WaitCustomValue[i].number);
								}
							}
							//檢查是否有已不在server上的資料 若有則remove()
						
							NumberSelector.children().each(function()
											{
												var flag=0;
												for(i=0;i<data.WaitCustomValue.length;i++)
												{	
													
													if(data.WaitCustomValue[i].number==$(this).val())
													{	
														flag=1;
														break;
													}
												}

												if(flag==0)
													{
														
														
														
														RemoveCustomList($(this).val());
														$(this).remove();
														

													}
											});
						}
						else
						{
							NumberSelector.children().remove();
							$("#CustomItemListBlock").html("");
							
							
						}
						if(data.WaitCustomValue!=-1)
							$('#WaitValue').html(data.WaitCustomValue.length);
						else
							$('#WaitValue').html("0");
						$('#NowValue').html(data.NowValue);
						$('#Value').html(data.Value);
						
						
						}
						
				},
		  dataType: "json"
		});
	window.setTimeout('GetValue("'+Item_Id+'");', 2000);




}
function Type2NextValue(SelectNumber,ItemID)
{			
		
		$.ajax({
		  type: 'POST',
		  url: 'Type2NextValue.php',
		  data: {"Number":SelectNumber,"ItemID":ItemID},
		  statusCode:{
				200:function(data)
					{	
						if(data==-2)
						{
							alert("此號碼正在被服務");
							return ;
						}
						if(data==-3)
						{
							alert('商品尚未全部完成');
							return ;
						}
	
						$('#NumberSelector').children("[value="+data.Now_Value+"]").remove();
						RemoveCustomList(data.Now_Value);
						
						$('#NumberSelector').children("[value="+data.Number+"]").attr("selected","selected");
						$('#NowValue').html(data.Number);
						//loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":data.Number});
						//$('#RightBlock').html("");
						
						
						
					}
			     },
		  dataType: "json"
		});


}

function FullScreenUpdateValue(Item_Id)
{	
		$.ajax({
		  type: 'POST',
		  url: 'updatevalue.php',
		  data: {"Item_Id":Item_Id,"Type":"2"},
		  statusCode:{
				200:function(data){
						if(data.WaitCustomValue!=-1)
							$('#FullScreenWaitValue').html(data.WaitCustomValue.length);
						else
							$('#FullScreenWaitValue').html("0");
						$('#FullScreenNowValue').html(data.NowValue);

						$('#FullScreenValue').html(data.Value);
						
						
						}
						
				},
		  dataType: "json"
		});

	//window.setTimeout('FullScreenUpdateValue("'+Item_Id+'");', 2000);
}
function CloseCustomItemWindow(SelectNumber)
{	
	$.ajax({
		  type: 'POST',
		  url: 'CloseCustomItemWindow.php',
		  data: {"Number":SelectNumber},
		  statusCode:{
				200:function(data){
						
						
						}
						
				},
		  dataType: "json"
		});

}
function GetStoreItemQueue()
{	
	var StoreItemQueueList=$('#StoreItemQueueList');
	$.ajax({
		  type: 'POST',
		  url: 'ItemQueueListUpdate.php',
		  data: {},
		  statusCode:{
				200:function(data){	
							
							
							for(var key in data)
							{	
								$button = $("<button class=\"StoreQueueFinishButton\" name=\""+data[key].Num+"\">"+data[key].Name+" "+data[key].Quantity+"</button>");
								$button.bind("click",FinishItemQueue);
								
								var Number=StoreItemQueueList.find("[name='"+data[key].Num+"']").size();
								if(Number==0)
								{	
									StoreItemQueueList.append($button);
									
									for(var i=0;i<10;i++)
									{
										var tempsize=$('.StoreItemButtonBlock').eq(i).children().size();
										if(tempsize==0)
										{
											$('.StoreItemButtonBlock').eq(i).append($button);
											break;
										}
												
									}
										

									
								}
								
								
				
							}
							
						
						}
						
				},
		  dataType: "json"
		});
	window.setTimeout('GetStoreItemQueue();', 2000);
}
function FinishItemQueue()
{
	var Num=$(this).attr("name");
	var Button = $(this);
	Button.remove();
	
	$.ajax({
		  type: 'POST',
		  url: 'ItemQueueFinish.php',
		  data: {'Num':Num},
		  statusCode:{
				200:function(data){	
							
							Button.remove();
							$('#ItemQueueBlock').load("ItemQueueList.php");

							var Count=$('#NumberSelector').children("[selected]").size();
							if(Count!=0)
							{	
								var Number=$('#NumberSelector').children("[selected]").val();
								//alert($('#NumberSelector').val());
								loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":Number});
							}
							else
							{	/*
								var Count=$('#NumberSelector').children().size();
								if(Count==1)
								{
									$('#NumberSelector').children().each(function(){
						
									loadpage("#CustomItemListBlock","ChooseCustomItem.php",{"CustomNumber":$(this).val()});
						
									});
								}
								*/
							}
							
							
							
						}
						
				},
		  dataType: "text"
		});
		
}

function EmptyQueue()
{

}
function UpdateCustomList(number)
{
		$("#CustomItemListBlock").append('<div class="ListBlock" id="Num'+number+'"></div>');
		$('#Num'+number).load('ChooseCustomItem.php',{"CustomNumber":number},function(){
								$(this).append("<hr>");
							});
		
		
}
function RemoveCustomList(number)
{

	$('#Num'+number).remove();
}

function ListStoreItem()
{	
	$.ajax({
		 type: 'POST',
		 url: 'ListStoreItem.php',
		 data: {},
		 statusCode:{
				200:function(data){
					if(data==null){
						$('#ItemQueueBlock').html("");
						return;
					}

					for(var i=0;i<data.length;i++){
						var ItemName = data[i].ItemName;
						var ItemID=data[i].ItemID;
						if($('.WaitItemBlock[name="'+ItemID+'"]').length==0){
							//建外面的ItemBlock 以ItemID為名字
							var AppendItem=$('<div name="'+ItemID+'" class="WaitItemBlock"></div>');
							//建立ItemName Block 並塞入ItemBlock
							var ItemNameBlock=$('<div class="WaitItemName">'+ItemName+'</div>');
							AppendItem.append(ItemNameBlock);
							//將ItemBlock塞入頁面的ItemQueueBlock
							$('#ItemQueueBlock').append(AppendItem);

						}
						else{
							//若Block已存在 則直接選取
							var AppendItem=$('.WaitItemBlock[name="'+ItemID+'"]');
						}						

						for(var j=0;j<data[i].WaitingCustomData.length;j++){	
							
							var CustomData=data[i].WaitingCustomData[j];
							var Count=AppendItem.children('.CustomDataBlock[name="'+CustomData.CustomNumber+'"]').length;
							if(Count==0){
								//建立一個CustomDataBlock

								var CustomDataBlock=$('<div name="'+CustomData.CustomNumber+'" class="CustomDataBlock"></div>');

									

								CustomDataBlock.append('<span class="WaitCustomNum">'+CustomData.CustomNumber+'號</span>');
								CustomDataBlock.append('<span class="WaitCustomQuan">'+CustomData.Quantity+'個</span>');	
								if(CustomData.Life==2)								
									CustomDataBlock.append('<span class="WaitStatus">製作中</span>');
								AppendItem.append(CustomDataBlock);
								
							}
							else{

								var SelectI=AppendItem.children('.CustomDataBlock[name="'+CustomData.CustomNumber+'"]');							
								var count=SelectI.children('.WaitStatus').length;
									
								if(CustomData.Life==2&&count==0)
								{
									SelectI.append('<span class="WaitStatus">製作中</span>');
								}
							}

						
						}

						//檢查CustomDataBlock裡的號碼是否還在server上 若沒有則remove
						AppendItem.children(".CustomDataBlock").each(function(){
								var Name=$(this).attr("name");
								var flag=0;
								for(var k=0;k<data[i].WaitingCustomData.length;k++){
									var CheckData=data[i].WaitingCustomData[k];
									if(CheckData.CustomNumber==Name){
										flag=1
										break;
									}
								}
								if(flag==0)
									$(this).remove();

							});

					}
					
					$('#ItemQueueBlock').children('.WaitItemBlock').each(function(){
						var ItemID=$(this).attr('name');
						var flag=0;						
						for(var l=0;l<data.length;l++){
							if(ItemID==data[l].ItemID){
								flag=1;
								break;
							}
							
						}
						if(flag==0)
							$(this).remove();
					});
	
				}
						
			},
		  dataType: "json"
		});

	window.setTimeout("ListStoreItem();",2000);
}
function WaitItemClickEvent(){
	
	var CustomNumber=$(this).attr('name');
	var ItemID=$(this).parent().attr('name');

	var Button=$(this);
	

	$.ajax({
		type:'POST',
		url:'ItemFinish.php',
		data:{"ItemID":ItemID,"CustomNumber":CustomNumber},
		success:function(data){
				//更新List
				$('#Num'+CustomNumber).load('ChooseCustomItem.php',{"CustomNumber":CustomNumber},function(){
								$(this).append("<hr>");
							});
				
				if(data==1)
					$('.WaitItemBlock[name="'+ItemID+'"]').children('.CustomDataBlock[name="'+CustomNumber+'"]').remove();

				if(data==2)
					$('.WaitItemBlock[name="'+ItemID+'"]').children('.CustomDataBlock[name="'+CustomNumber+'"]').append('<span class="WaitStatus">製作中</span>');
			
			},
		dataType:"text"
		});
	

}

function WaitItemModeUpdate(GetItemID){
$.ajax({
		 type: 'POST',
		 url: 'ListStoreItem.php',
		 data: {},
		 statusCode:{
				200:function(data){
					if(data==null){
						//$('#ItemQueueBlock').html("");
						$(".CustomDataBlock").each().html("");
						return;
					}

					for(var i=0;i<data.length;i++){
						var ItemName = data[i].ItemName;
						var ItemID=data[i].ItemID;

						var AppendItem=$('.WaitCustomList[name="'+ItemID+'"]');
						

						for(var j=0;j<data[i].WaitingCustomData.length;j++){	
							
							var CustomData=data[i].WaitingCustomData[j];
							var Count=AppendItem.children('.CustomDataBlock[name="'+CustomData.CustomNumber+'"]').length;
							if(Count==0){
								//建立一個CustomDataBlock

								var CustomDataBlock=$('<div name="'+CustomData.CustomNumber+'" class="CustomDataBlock"></div>');

								CustomDataBlock.append('<div class="WaitCustomNum">'+CustomData.CustomNumber+'號</div>');
								CustomDataBlock.append('<div class="WaitCustomQuan">'+CustomData.Quantity+'個</div>');	
								if(CustomData.Life==2)								
									CustomDataBlock.append('<span class="WaitStatus">製作中</span>');
								AppendItem.append(CustomDataBlock);
								
							}
							else{

								var SelectI=AppendItem.children('.CustomDataBlock[name="'+CustomData.CustomNumber+'"]');							
								var count=SelectI.children('.WaitStatus').length;
									
								if(CustomData.Life==2&&count==0)
								{
									SelectI.append('<div class="WaitStatus">製作中</div>');
								}
							}

						
						}

						//檢查CustomDataBlock裡的號碼是否還在server上 若沒有則remove


					}
					
					$(".CustomDataBlock").each(function(){
								var Name=$(this).attr("name");
								var ItemID=$(this).parent().attr('name');

								
								var flag=0;
								for(var k=0;k<data.length;k++)
								{
									var testItemID=data[k].ItemID;
									if(testItemID==ItemID){
										for(var l=0;l<data[k].WaitingCustomData.length;l++){
											var CheckData=data[k].WaitingCustomData[l];
											if(CheckData.CustomNumber==Name){
												
												flag=1
												//alert(flag);
												break;
											}	
										}
									}
								}
								//
								if(flag==0)
								{	

									$(this).remove();
									
								}

							});
					
					
				}
						
			},
		  dataType: "json"
		});

window.setTimeout("WaitItemModeUpdate();",2000);
}

function ShowMenu(){
	var MenuBar='<div class="MenuBar"><li><dt id="MenuText">選單</dt></li></div>';
	$('#IndexPage').append(MenuBar);


	$.ajax({
		type:'POST',
		url:'controlbar.php',
		data:{},
		success:function(data){
			var a=data;
			$('#MenuText').parent().append(a);
			
			},
		dataType:"text"
		});
	

}
function UpdateOneItemScreen(ItemID){
 	$.post('updatevalue.php',
		 {"Item_Id":ItemID,"Type":"1"},
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
	window.setTimeout("UpdateOneItemScreen('"+ItemID+"');",2000);

}


