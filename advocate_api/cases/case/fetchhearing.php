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
$sql = "select `id`, `case_id`, `next_date`, `last_date`, `notes`, `hearing_docs` FROM hearingdates WHERE `case_id` ='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['case_id'] = $row['case_id'];
	$todolist[$cr]['next_date'] = $row['next_date'];
	$todolist[$cr]['last_date'] = $row['last_date'];
	$todolist[$cr]['notes'] = $row['notes'];
	$todolist[$cr]['hearing_docs'] = $row['hearing_docs'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
