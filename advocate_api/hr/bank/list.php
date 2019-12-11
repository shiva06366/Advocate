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
$sql = "SELECT `id`, `account_holder_name`, `account_number`, `bank_name`, `ifsc_code`, `pan_number`, `branch` FROM `bank` where user_id='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['account_holder_name'] = $row['account_holder_name'];
    $todolist[$cr]['account_number']   = $row['account_number'];
    $todolist[$cr]['bank_name']   = $row['bank_name'];
    $todolist[$cr]['ifsc_code']   = $row['ifsc_code'];
    $todolist[$cr]['pan_number']   = $row['pan_number'];
    $todolist[$cr]['branch']   = $row['branch'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
