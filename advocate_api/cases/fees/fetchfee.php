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
$sql = "SELECT `id`, `case_title`, `case_no`, `total_fees` FROM `cases` WHERE `id` ='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $case_id=$row['id'];
	  $sql_rec="select sum(amount) as amount from receipt where case_id='{$case_id}'";
	  $result_rec=mysqli_query($con,$sql_rec);
	  $row_rec=mysqli_fetch_assoc($result_rec);
	  $sql_inv="SELECT AUTO_INCREMENT as inv_id FROM  information_schema.TABLES WHERE TABLE_SCHEMA = 'advocate_db' AND TABLE_NAME = 'invoice'";
	  $result_inv=mysqli_query($con,$sql_inv);
	  $row_inv=mysqli_fetch_assoc($result_inv); 
	$todolist[$cr]['case_title'] = $row['case_title'];
    $todolist[$cr]['case_no']   = $row['case_no'];
    $todolist[$cr]['total_fees']   = $row['total_fees'];
    $todolist[$cr]['amount_paid']   = $row_rec['amount'];
    $todolist[$cr]['inv_no']   = $row_inv['inv_id'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
