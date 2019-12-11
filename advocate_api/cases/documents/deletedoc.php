<?php
require '../../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}    
$todolist = [];

$sql1 = "select `id`, `document_id`, `document_name`, `document_file` FROM  adddocument_manage WHERE `id` ='{$id}'";
$result1 = mysqli_query($con,$sql1);
$row1 = mysqli_fetch_assoc($result1);
$path=basename($row1['document_file']);
$fullpath="C:/xampp/htdocs/advocate_api/cases/documents/uploads/".$path;
//echo $fullpath;
if(unlink($fullpath)){}
$sql = "DELETE FROM `adddocument_manage` WHERE id='{$id}'";
if($result = mysqli_query($con,$sql))
{
   http_response_code(201);
   echo json_encode(['output'=>true]);
}
else
{
  http_response_code(404);
}
