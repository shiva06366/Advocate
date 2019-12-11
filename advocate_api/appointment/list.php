<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
    
$todolist = [];
$sql = "SELECT `id`, `title`, `contact`, `motive`, `date_time`, `notes` FROM `appointment`";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['title'] = $row['title'];
    $todolist[$cr]['contact']   = $row['contact'];
    $todolist[$cr]['motive']   = $row['motive'];
    $todolist[$cr]['date_time']   = $row['date_time'];
    $todolist[$cr]['notes']   = $row['notes'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
