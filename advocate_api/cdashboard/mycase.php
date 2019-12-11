<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}       
$todolist = [];
$sql = "SELECT COUNT(*) as total_cases FROM `cases` where client_name='{$id}'";

$sql1 = "SELECT days FROM `case_alert_days` where user_id!='{$id}'";


$result = mysqli_query($con,$sql);
$result1 = mysqli_query($con,$sql1);

$row = mysqli_fetch_assoc($result);
$row1 = mysqli_fetch_assoc($result1);


if($result = mysqli_query($con,$sql))
{
  $cr = 0;

   $todolist[$cr]['total_cases']      		= $row['total_cases'];
   $todolist[$cr]['days'] 				= $row1['days'];
   
    $cr++;
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
