<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}    
$todolist = [];
$sql = "SELECT `id`, `task_id`, `msg_from`, `message`, `date` FROM `task_message`  where task_id= '{$id}' ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  $row = mysqli_fetch_assoc($result);
  
	  $sql1= "SELECT `name`, `case_id` FROM `tasks` WHERE `id` = '{$id}' ";
	  $result1 = mysqli_query($con,$sql1);
	  $row1 = mysqli_fetch_assoc($result1);
		
			$case_name=$row1['name'];
			
			
	
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['case_name'] = $case_name;
	
    $cr++;
  
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
