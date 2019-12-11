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
$sql = "SELECT id,name,location,court_category,description FROM court WHERE `id` ='{$id}'";
//echo $sql;
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
	$todolist[$cr]['location'] = $row['location'];
	$todolist[$cr]['court_category'] = $row['court_category'];
	$todolist[$cr]['description'] = $row['description'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
