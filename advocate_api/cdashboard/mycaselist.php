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
$sql = "SELECT `id`, `case_no` FROM `cases` where client_name='{$id}'";

$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['case_no']      		= $row['case_no'];
   $todolist[$cr]['id'] 				= $row['id'];
   $cr++;
  }
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}