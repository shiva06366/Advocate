<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
$time=date("H:i:s");
$date=date("Y-m-d");	
$markin='markin';
$user_id=mysqli_real_escape_string($con, trim($request->data->userId));
$notes = mysqli_real_escape_string($con, trim($request->data->notes));

$sql ="INSERT INTO `markin`(`id`, `user_id`, `notes`, `date`, `time`, `availability`) VALUES (null, '{$user_id}', '{$notes}','{$date}', '{$time}', '{$markin}' )";
 if(mysqli_query($con,$sql))
  {
	  $sql1 ="INSERT INTO `markin_temp`(`id`, `user_id`, `notes`, `date`, `time`, `availability`) VALUES (null, '{$user_id}', '{$notes}','{$date}', '{$time}', '{$markin}' )";
	  mysqli_query($con,$sql1);
	  $add = [
	  'notes' => $notes,
	  'date' => $date,
	  'time' => $time,
	  'availability' => $markin,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add]);
  }
}
?>