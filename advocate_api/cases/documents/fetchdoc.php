<?php
require '../../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}    
$todolist = [];
$sql = "select `id`, `document_id`, `document_name`, `document_file` FROM  adddocument_manage WHERE `document_id` ='{$id}'";
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $sql1 = "SELECT type,case_name, title FROM `adddocuments` where id='{$id}'";
	  $result1 = mysqli_query($con,$sql1);
	  $row1 = mysqli_fetch_assoc($result1);
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['document_id'] = $row['document_id'];
	$todolist[$cr]['document_name'] = $row['document_name'];
	$todolist[$cr]['document_file'] = basename($row['document_file']);
	$todolist[$cr]['title']=$row1['title'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
