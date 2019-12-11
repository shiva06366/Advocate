<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id, case_title, case_no, client_name, starred_cases FROM `cases` where starred_cases='1' ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $client_no=$row['client_name'];
	$sql1="SELECT name FROM `employees` where id= '{$client_no}'";
	$result1 = mysqli_query($con,$sql1);
	$row1 = mysqli_fetch_assoc($result1);
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['case_title'] = $row['case_title'];
    $todolist[$cr]['case_no']   = $row['case_no'];
    $todolist[$cr]['client_name']   = $row1['name'];
    $todolist[$cr]['starred_cases']   = $row['starred_cases'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
