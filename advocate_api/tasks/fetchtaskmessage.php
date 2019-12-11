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
  while($row = mysqli_fetch_assoc($result))
  {
	  $sql1= "SELECT `name`, `case_id` FROM `tasks` WHERE `id` = '{$id}' ";
	  $result1 = mysqli_query($con,$sql1);
	  while($row1 = mysqli_fetch_assoc($result1))
		{
			$case_name=$row1['name'];
			
			
		}
		$emp_id=$row['msg_from'];
		
	$sql2="SELECT `name` FROM `employees` where id='{$emp_id}'";
	$result2= mysqli_query($con,$sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$emp_name = ucfirst($row2['name']);
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['msg_from'] = $emp_name;
	$todolist[$cr]['message'] = $row['message'];
	$todolist[$cr]['date'] = $row['date'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist,'case_name' => $case_name]);
}
else
{
  http_response_code(404);
}
