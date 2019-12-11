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
$sql = "SELECT `inv_no`, `pay_mode`, `date`, `tot_amt` FROM `invoice` WHERE case_id='{$id}'";
//echo $sql;
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $pay_mode=$row['pay_mode'];
	  $sql_pay="SELECT `id`, `name` FROM `payment_mode` WHERE id='{$pay_mode}'";
	  $result_pay=mysqli_query($con,$sql_pay);
	  $row_pay=mysqli_fetch_assoc($result_pay);
   $todolist[$cr]['inv_no']      = $row['inv_no'];
	$todolist[$cr]['pay_mode'] = $row_pay['name'];
	$todolist[$cr]['date'] = $row['date'];
	$todolist[$cr]['amount'] = $row['tot_amt'];
	$cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
