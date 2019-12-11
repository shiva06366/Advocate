<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id,name,user_role,status  FROM employees WHERE user_role='3' and status='active'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $user_role= $row['user_role'];
	  $sql1="SELECT `id`, `user_type` FROM `user_role` WHERE id= '{$user_role}'";
	  $result1=mysqli_query($con,$sql1);
	  $row1=mysqli_fetch_assoc($result1);
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
    $todolist[$cr]['user_role']   = $row1['user_type'];
    $todolist[$cr]['status']   = $row['status'];

    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
