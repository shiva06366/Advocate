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
$sql = "SELECT `id`, `dept_name`, `dept_description` FROM `departments` WHERE `id` ='{$id}'";
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $sql2= "SELECT `id`, `sr_no`, `designation` FROM `dept_designation` WHERE sr_no='{$id}'";
	$result2 = mysqli_query($con,$sql2);
	$designation1='';
	while($row2 = mysqli_fetch_assoc($result2))
	{
		$designation = $row2['designation'];
		$designation1 = ltrim($designation1.",". $designation,",");
	}
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['dept_name'] = $row['dept_name'];
	$todolist[$cr]['dept_description'] = $row['dept_description'];
	$todolist[$cr]['designation'] = $designation1;
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
