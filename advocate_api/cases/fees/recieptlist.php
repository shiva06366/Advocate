
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
$sql = "SELECT `date`, `amount`  FROM `receipt` WHERE  case_id='{$id}'";
//echo $sql;
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {

	$todolist[$cr]['date'] = $row['date'];
	$todolist[$cr]['amount'] = $row['amount'];
	$cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
