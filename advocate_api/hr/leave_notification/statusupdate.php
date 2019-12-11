<?php

require '../../connect.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "SELECT `id`, `user_id`, `date`, `leave_type`, `reason`, `status`, `approve_date` FROM `apply_leave` WHERE `id` ='{$id}'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
if($row['status']=='accept'){
	$sql2= "UPDATE `apply_leave` SET `status` = NULL WHERE `apply_leave`.`id` = '{$id}';";
}
else{
	$sql2= "UPDATE `apply_leave` SET `status` = 'accept' WHERE `apply_leave`.`id` = '{$id}';";
}

//echo $sql;die();
if(mysqli_query($con, $sql2))
{
  http_response_code(204);
}
else
{
  return http_response_code(422);
}
?>