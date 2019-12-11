<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT `id`, `dept_name`, `dept_description` FROM `departments`";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	$sr_no=$row['id'];
	$sql2= "SELECT `id`, `sr_no`, `designation` FROM `dept_designation` WHERE sr_no='{$sr_no}'";
	$result2 = mysqli_query($con,$sql2);
	$designation1='';
	while($row2 = mysqli_fetch_assoc($result2))
	{
		$designation = $row2['designation'];
		$designation1 = ltrim($designation1.",". $designation,",");
	}
	
	//echo $designation1;
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['dept_name'] = $row['dept_name'];
    $todolist[$cr]['dept_description']   = $row['dept_description'];
    $todolist[$cr]['designation']   = $designation1;
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
