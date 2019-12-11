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
$sql1="UPDATE `cases` SET `archived_cases` = '0' WHERE `id` = '{$id}'";
	  mysqli_query($con, $sql1);

$sql="DELETE FROM `archivedcases` WHERE `case_id`='{$id}'";

if($result = mysqli_query($con,$sql))
{
   http_response_code(201);
   echo json_encode(['output'=>true]);
}
else
{
  http_response_code(404);
}
