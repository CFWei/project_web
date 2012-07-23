<?php
	$custom_id=$_POST['custom_id'];
	//$custom_id="356514044378347";
	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="SELECT custom_id,store,item,number FROM  custom_information where `custom_id` = '".$custom_id."' and life='0'";
	$db->query($query);
	$db->get_num_rows();
	


	while($temp=$db->fetch_assoc())
		$output[]=$temp;

	
	for($i=0;$i<count($output);$i++)
	{	
		$check_num=1;

		$query="SELECT StoreName,GPS_Longitude,GPS_Latitude FROM store_information where `SerialNumbers` = '".$output[$i]['store']."'";
		$db->query($query);
		if($db->get_num_rows()==1)
		{
			$temp=$db->fetch_assoc();
			$StoreName=$temp['StoreName'];
			$GPS_Longitude=$temp['GPS_Longitude'];
			$GPS_Latitude=$temp['GPS_Latitude'];
		}
		else
		{
			$check_num=0;
		}
		
		
		$query="SELECT Name FROM ".$output[$i]['store']." where `ID` = '".$output[$i]['item']."'";
		$db->query($query);
		if($db->get_num_rows()==1)
		{
			$temp=$db->fetch_assoc();
			$ItemName=$temp['Name'];
		}		
		else
		{
			$check_num=0;
		}

		if($check_num==1)
		{
			$output[$i]['StoreName']=$StoreName;
			$output[$i]['ItemName']=$ItemName;
			$output[$i]['GPS_Longitude']=$GPS_Longitude;
			$output[$i]['GPS_Latitude']=$GPS_Latitude;
			$output_final[]=$output[$i];
		}
		else
		{
			$query="DELETE FROM `custom_information` WHERE `custom_id` = '".$output[$i]['custom_id']."' and `store` = '".$output[$i]['store']."' and `item` ='".$output[$i]['item']."' and `number` ='".$output[$i]['number']."'";
			$db->query($query);
		}	
		

	}


	echo json_encode($output_final);
?>
