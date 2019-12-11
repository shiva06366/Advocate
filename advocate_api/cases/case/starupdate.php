<?php

require '../../connect.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "select `starred_cases`  FROM `cases`  WHERE `id` ='{$id}'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
if($row['starred_cases']=='1'){
	$sql2= "UPDATE `cases` SET `starred_cases` = '0' WHERE `cases`.`id` = '{$id}';";
}
else{
	$sql2= "UPDATE `cases` SET `starred_cases` = '1' WHERE `cases`.`id` = '{$id}';";
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