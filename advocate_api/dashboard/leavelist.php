
<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';


$sql="SELECT `id`, `leavetype`, `description`, `leaves` FROM `leaves`";
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['leavetype'] = $row['leavetype'];
	$todolist[$cr]['description'] = $row['description'];
	$todolist[$cr]['leaves'] = $row['leaves'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}