<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id, case_title, case_no FROM `cases` where archived_cases='0'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['case_title'] = $row['case_title'];
    $todolist[$cr]['case_no']   = $row['case_no'];
   
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
