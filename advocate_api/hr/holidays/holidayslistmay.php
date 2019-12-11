<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id,name,dates,DAYNAME(dates) as dayname FROM holidays WHERE MONTH(dates)=5";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
    $todolist[$cr]['dates']   = mysqli_real_escape_string($con, date( 'm-d-y', strtotime($row['dates'])));
	$todolist[$cr]['dayname'] = $row['dayname'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
