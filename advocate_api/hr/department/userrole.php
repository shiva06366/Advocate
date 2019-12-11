<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id,user_type  FROM user_role where id!=2";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $todolist[$cr]['id'] = $row['id'];
	$todolist[$cr]['user_type'] = $row['user_type'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
