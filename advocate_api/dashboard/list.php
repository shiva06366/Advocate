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
$sql = "SELECT COUNT(*) as no_clients FROM `employees` where user_role='3'";

$sql1 = "SELECT COUNT(*) as no_cases FROM `cases` where archived_cases!='1'";

$sql2 = "SELECT COUNT(*) as no_starred_cases FROM `cases`  where starred_cases=1";

$sql3 = "SELECT COUNT(*) as no_archived_cases FROM `cases`  where archived_cases=1";

$sql4 = "SELECT COUNT(*) as no_employees FROM `employees` where user_role!='3'";

$sql5 = "select count(*) as no_tasks from `tasks`";

$sql6 = "SELECT count(*) as no_casestudy FROM `casestudy`";

$sql7 = "SELECT count(*) as no_mytasks FROM `tasks_assign` where emp_id='{$id}'";

$result = mysqli_query($con,$sql);
$result1 = mysqli_query($con,$sql1);
$result2 = mysqli_query($con,$sql2);
$result3 = mysqli_query($con,$sql3);
$result4 = mysqli_query($con,$sql4);
$result5 = mysqli_query($con,$sql5);
$result6 = mysqli_query($con,$sql6);
$result7 = mysqli_query($con,$sql7);

$row = mysqli_fetch_assoc($result);
$row1 = mysqli_fetch_assoc($result1);
$row2 = mysqli_fetch_assoc($result2);
$row3 = mysqli_fetch_assoc($result3);
$row4 = mysqli_fetch_assoc($result4);
$row5 = mysqli_fetch_assoc($result5);
$row6 = mysqli_fetch_assoc($result6);
$row7 = mysqli_fetch_assoc($result7);


if($result = mysqli_query($con,$sql))
{
  $cr = 0;

   $todolist[$cr]['no_clients']      		= $row['no_clients'];
	$todolist[$cr]['no_cases'] 				= $row1['no_cases'];
    $todolist[$cr]['no_starred_cases']   	= $row2['no_starred_cases'];
    $todolist[$cr]['no_archived_cases']   	= $row3['no_archived_cases'];
    $todolist[$cr]['no_employees']   		= $row4['no_employees'];
	$todolist[$cr]['no_tasks']   			= $row5['no_tasks'];
	$todolist[$cr]['no_casestudy']   		= $row6['no_casestudy'];
	$todolist[$cr]['no_mytasks']   			= $row7['no_mytasks'];
    $cr++;
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
