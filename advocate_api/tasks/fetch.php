<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}    
$todolist = [];
$sql = "SELECT `id`, `name`, `priority`, `due_date`, `case_id`, `progress`, `description`, `created_by` FROM `tasks` where id= '{$id}' ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  
	  $sql2="SELECT `id`, `task_id`, `emp_id`  FROM `tasks_assign` where task_id='{$id}'";
	  $created_by_name='';
	  $result2 = mysqli_query($con,$sql2);
	  while($row2 = mysqli_fetch_assoc($result2))
	  {
		  $emp_id=$row2['emp_id'];
	$sql1="SELECT name FROM `employees` where id= '{$emp_id}'";
	
	$result1 = mysqli_query($con,$sql1);
	
	while($row1 = mysqli_fetch_assoc($result1))
	{
		$emp_name = ucfirst($row1['name']);
		$created_by_name = rtrim(ltrim($created_by_name.",". $emp_name,","));
	}
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
