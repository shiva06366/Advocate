<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id,name,gender,dob,email,username,phone,address  from employees WHERE user_role='2' ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
    $todolist[$cr]['gender']   = $row['gender'];
    $todolist[$cr]['dob']   = $row['dob'];
    $todolist[$cr]['email']   = $row['email'];
    $todolist[$cr]['username']   = $row['username'];
    $todolist[$cr]['phone']   = $row['phone'];
    $todolist[$cr]['address']   = $row['address'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
