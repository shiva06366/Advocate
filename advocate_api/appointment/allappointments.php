<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
    
$todolist = [];
$sql = "SELECT `id`, `title`,`date_time`, `notes` FROM `appointment`";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['title'] = $row['title'];
   $todolist[$cr]['start']   = $row['date_time'];
    $todolist[$cr]['notes']   = $row['notes'];
	  $todolist[$cr]['color']= "#3c8dbc";
    $cr++;
  }
	
   $sql1= "select `id`, `case_title`, `hearing_date`, `description` From `cases` WHERE `archived_cases` !=1";
	$result1=mysqli_query($con,$sql1);
	
	while($row1 = mysqli_fetch_assoc($result1)){
		 $todolist[$cr]['id']      = $row1['id'];
	$todolist[$cr]['title'] = $row1['case_title'];
   $todolist[$cr]['start']   = $row1['hearing_date'];
    $todolist[$cr]['notes']   = $row1['description'];
	  $todolist[$cr]['color']= "#edaba2";
    $cr++;
		
	}
	echo json_encode($todolist);
}
else
{
  http_response_code(404);
}
