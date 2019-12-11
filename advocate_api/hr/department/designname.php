<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
$id = ($_GET['dep_id'] !== null && (int)$_GET['dep_id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['dep_id']) : false;
if(!$id)
{
  return http_response_code(400);
} 
  
$todolist = [];
$sql = "SELECT `id`, `designation` FROM `dept_designation` where sr_no='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['designation'] = $row['designation'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
