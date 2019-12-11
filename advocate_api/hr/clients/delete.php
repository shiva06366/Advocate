<?php

require '../../connect.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "DELETE FROM `employees` WHERE `id` ='{$id}'";
//echo $sql;die();
if(mysqli_query($con, $sql))
{
  http_response_code(201);
  echo json_encode(['output'=>true]);
}
else
{
  return http_response_code(422);
}
?>