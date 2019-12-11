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
$sql = "SELECT id,name FROM `employees` where `id` !='{$id}' ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
    
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
