<?php

/**
 * Returns the list of cars.
 */
require '../../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}    
$todolist = [];
$sql = "Delete from cases WHERE `id` ='{$id}'";
$sql1 = "Delete from cases_case_category WHERE `case_id` ='{$id}'";
$sql2 = "Delete from cases_act WHERE `case_id` ='{$id}'";
$sql3="DELETE FROM `archivedcases` WHERE `case_id`='{$id}'";


if($result = mysqli_query($con,$sql))
{
	mysqli_query($con,$sql1);
	mysqli_query($con,$sql2);
	mysqli_query($con,$sql3);
   http_response_code(201);
   echo json_encode(['output'=>true]);
}
else
{
  http_response_code(404);
}
