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
$sql = "SELECT `id`, `name`, `email`, `username` FROM `employees` WHERE `id`= '$id'";

$result = mysqli_query($con,$sql);

$row = mysqli_fetch_assoc($result);



if($result = mysqli_query($con,$sql))
{
  $cr = 0;

   $todolist[$cr]['id']      		= $row['id'];
	$todolist[$cr]['name'] 			= $row['name'];
    $todolist[$cr]['email']   		= $row['email'];
    $todolist[$cr]['username']   	= $row['username'];
    $cr++;
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
