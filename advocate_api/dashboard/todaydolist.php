<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$today_date=date("Y-m-d");

$sql="SELECT id,name,description,date_time FROM `to_do_list` where date_time='$today_date'";
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
	$todolist[$cr]['description'] = $row['description'];
	$todolist[$cr]['today_date'] = $today_date;
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}