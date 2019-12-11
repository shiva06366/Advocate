<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

$name = mysqli_real_escape_string($con, trim($request->data->name));
$date =mysqli_real_escape_string($con, date( 'Y-m-d', strtotime( trim($request->data->dates) ) ));

$sql ="INSERT INTO `holidays`(`name`, `dates`) VALUES ('{$name}','{$date}')";
 if(mysqli_query($con,$sql))
  {
	  $add = [
	  'name' => $name,
	  'date' => $date,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
}
?>