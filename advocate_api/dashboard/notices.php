<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$today_date=date("Y-m-d");

$sql="SELECT id,title,date_time FROM `notice`";
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['title'] = $row['title'];
	$todolist[$cr]['date_time'] = $row['date_time'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}