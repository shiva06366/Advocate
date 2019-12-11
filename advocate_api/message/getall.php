<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;
$userid = ($_GET['userid'] !== null && (int)$_GET['userid'] > 0)? mysqli_real_escape_string($con, (int)$_GET['userid']) : false;

if(!$id)
{
  return http_response_code(400);
}       
$todolist = [];
$sql = "SELECT id,user_from,message,date FROM `message_user` where (user_from='{$userid}' and user_to='{$id}') || (user_from='{$id}' and user_to='{$userid}')";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $emp_id=$row['user_from'];
		
	$sql2="SELECT `name` FROM `employees` where id='{$emp_id}'";
	$result2= mysqli_query($con,$sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$emp_name = ucfirst($row2['name']);
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['user_from'] = $emp_name;
	$todolist[$cr]['message'] = $row['message'];
	$todolist[$cr]['date'] = $row['date'];
    
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
