<?php

require '../connect.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "DELETE FROM `casestudy` WHERE `id` ='{$id}'";
$sql2 = "DELETE FROM `casestudy_category` WHERE `casestudy_id` ='{$id}'";

if(mysqli_query($con, $sql) && mysqli_query($con, $sql2))
{
  http_response_code(201);
  echo json_encode(['output'=>true]);
}
else
{
  return http_response_code(422);
}
?>