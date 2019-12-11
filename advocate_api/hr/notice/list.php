<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id,title,description,date_time  FROM notice ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['title'] = $row['title'];
    $todolist[$cr]['description']   = $row['description'];
    $todolist[$cr]['date_time']   = $row['date_time'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
