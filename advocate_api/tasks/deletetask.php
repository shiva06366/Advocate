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
$sql  = "DELETE FROM `tasks` WHERE  `id` ='{$id}'";
$sql1 = "DELETE FROM `tasks_assign` WHERE `task_id` ='{$id}'";

if($result = mysqli_query($con,$sql) && $result1 = mysqli_query($con,$sql1))
{
   http_response_code(201);
   echo json_encode(['output'=>true]);
}
else
{
  http_response_code(404);
}
