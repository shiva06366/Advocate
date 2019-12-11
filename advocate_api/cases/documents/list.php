<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT id, type,case_name, title FROM `adddocuments`";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['title'] = $row['title'];
	$todolist[$cr]['type'] = $row['type'];
	$case_no= $row['case_name'];
	$sql1 = "SELECT id, case_title, case_no FROM `cases` where archived_cases!='1' and id='$case_no' ";
	$result1 = mysqli_query($con,$sql1);
	$row1 = mysqli_fetch_assoc($result1);
	$todolist[$cr]['case_name'] = $row1['case_no']." ".$row1['case_title'];
    $cr++;
  }    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
