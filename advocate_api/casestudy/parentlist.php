<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
    
$todolist = [];
$sql = "SELECT id,category_name FROM case_category ";
//echo $sql;
if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $todolist[$cr]['item_id']      = $row['id'];
	$todolist[$cr]['item_text'] = $row['category_name'];
	$cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
