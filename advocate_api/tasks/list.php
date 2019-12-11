<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
    
$todolist = [];
$sql = "SELECT `id`, `name`, `priority`, `due_date`, `case_id`, `progress`, `description`, `created_by` FROM `tasks` ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $created_by=$row['created_by'];
	$sql1="SELECT name FROM `employees` where id= '{$created_by}'";
	
	$result1 = mysqli_query($con,$sql1);
	$created_by_name='';
	while($row1 = mysqli_fetch_assoc($result1))
	{
		$emp_name = ucfirst($row1['name']);
		$created_by_name = rtrim(ltrim($created_by_name.",". $emp_name,","));
	}
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
    $todolist[$cr]['priority']   = $row['priority'];
    $todolist[$cr]['due_date']   = $row['due_date'];
    $todolist[$cr]['case_id']   = $row['case_id'];
    $todolist[$cr]['progress']   = $row['progress'];
    $todolist[$cr]['description']   = $row['description'];
    $todolist[$cr]['created_by']   = $created_by_name;
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
