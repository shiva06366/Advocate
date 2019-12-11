<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$todolist1 = [];
$sql = "SELECT id,user_type FROM `user_role` WHERE id >2";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $todolist[$cr]['id'] = $row['id'];
	$todolist[$cr]['user_type'] = $row['user_type'];
	$user_id=$row['id'];
  $sql1 = "SELECT `access1`, `access2`, `access3`, `access4`, `access5`, `access6`, `access7`, `access8`, `access9`, `access10`, `access11`, `access12`, `access13`, `access14`, `access15`, `access16`, `access17`, `access18`, `access19`, `access20`, `access21`, `access22`, `access23`, `access24`, `access25`, `access26`, `access27`, `access28`, `access29`, `access30`, `access31`, `access32`, `access33`, `access34`, `access35`, `access36`, `access37`, `access38`, `access39`, `access40`, `access41`, `access42`, `access43`, `access44`, `access45`, `access46`, `access47`, `access48`, `access49`, `access50`, `access51`, `access52`, `access53`, `access54`, `access55`, `access56`, `access57`, `access58`, `access59`, `access60`, `access61`, `access62`, `access63`, `access64`, `access65`, `access66`, `access67`, `access68`, `access69`, `access70`, `access71`, `access72`, `access73`, `access74`, `access75`, `access76`, `access77`, `access78`, `access79`, `access80`, `access81`, `access82`, `access83`, `access84`, `access85`, `access86`, `access87`, `access88`, `access89`, `access90`, `access91`, `access92`, `access93`, `access94`, `access95`, `access96`, `access97`, `access98`, `access99`, `access100`, `access101`, `access102`, `access103`, `access104`, `access105`, `access106`, `access107`, `access108`, `access109`, `access110`, `access111`, `access112`, `access113`, `access114`, `access115`, `access116`, `access117`, `access118`, `access119`, `access120`, `access121`, `access122`, `access123`, `access124`, `access125`, `access126`, `access127`, `access128`, `access129`, `access130`, `access131`, `access132`, `access133`, `access134`, `access135`, `access136`, `access137`, `access138`, `access139`, `access140`, `access141`, `access142`, `access143` FROM `adpermission` where user_id='{$user_id}'";
if($result1 = mysqli_query($con,$sql1))
{
  while($row1 = mysqli_fetch_assoc($result1))
  {
	 
	  for($i=1;$i<=143;$i++)
	  {
		  $access= "access".$i;
		  if($row1[$access]!='' && $row1[$access]!='false' ){
		  $todolist[$cr]['access'][$access] = true;
		  }
		  else {
			$todolist[$cr]['access'][$access] = false;  
		  }
	  }

  }
 $cr1++;
}
    $cr++;
	
  }
    
echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
