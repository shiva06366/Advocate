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
$sql = "SELECT tasks.id,tasks.name, tasks.priority,tasks.due_date,tasks.case_id,tasks.progress,tasks.description,tasks.created_by 
FROM tasks
INNER JOIN tasks_assign ON tasks.id=tasks_assign.task_id WHERE emp_id= '{$id}' ";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $created_by=
	  $sql2="SELECT `id`, `task_id`, `emp_id`  FROM `tasks_assign` where task_id='{$id}'";
	  $created_by=$row['created_by'];
	 
		  $emp_id=$row2['emp_id'];
	$sql1="SELECT name FROM `employees` where id= '{$created_by}'";
	
	$result1 = mysqli_query($con,$sql1);
	
	$row1 = mysqli_fetch_assoc($result1);
	
		$emp_name = ucfirst($row1['name']);
		$created_by_name = rtrim(ltrim($emp_name));
	
	  
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
