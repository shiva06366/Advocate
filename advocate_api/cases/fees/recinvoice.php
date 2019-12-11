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
$sql = "SELECT `inv_no` FROM `invoice` WHERE case_id='{$id}'";
//echo $sql;
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	$inv_no=$row['inv_no'];
	$sql_rec="select inv_no from receipt where inv_no='{$inv_no}'";
	$result_rec=mysqli_query($con,$sql_rec);
	$row_rec=mysqli_fetch_assoc($result_rec);
	if($row_rec['inv_no']!= $row['inv_no']){
   $todolist[$cr]['inv_no']      = $row['inv_no'];
   $cr++;
	}
	
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
