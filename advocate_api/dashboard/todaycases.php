<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$today_date=date("Y-m-d");

$sql="SELECT id,case_title,description FROM `cases` where Date(case_created_date)='$today_date'";
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['case_title'] = $row['case_title'];
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