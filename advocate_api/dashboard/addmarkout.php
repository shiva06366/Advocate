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
$markin='markout';
$user_id=mysqli_real_escape_string($con, trim($request->data->userId));
$notes = mysqli_real_escape_string($con, trim($request->data->notesmarkout));

$sql ="INSERT INTO `markin`(`id`, `user_id`, `notes`, `date`, `time`, `availability`) VALUES (null, '{$user_id}', '{$notes}','{$date}', '{$time}', '{$markin}' )";
 if(mysqli_query($con,$sql))
  {
	  $sql1 ="INSERT INTO `markin_temp`(`id`, `user_id`, `notes`, `date`, `time`, `availability`) VALUES (null, '{$user_id}', '{$notes}','{$date}', '{$time}', '{$markin}' )";
	  mysqli_query($con,$sql1);
	  $sql2="select time from markin_temp where user_id='{$user_id}' and date='{$date}'";
	  $result = mysqli_query($con,$sql2);
	  $cr=0;
	  while($row = mysqli_fetch_assoc($result))
	  {
		  $temp[$cr]= $row['time'];
		  $cr++;
	  }
$sql3="SELECT TIMEDIFF('$temp[1]', '$temp[0]') as timediff";
 $result1 = mysqli_query($con,$sql3);
 $row1 = mysqli_fetch_assoc($result1);
 $timediff=$row1['timediff'];
 $sql4="INSERT INTO `user_timing`(`id`, `user_id`, `date`, `time`) VALUES (null, '{$user_id}', '{$date}', '{$timediff}')";
 mysqli_query($con,$sql4);
 $sql5="Delete from markin_temp where user_id='{$user_id}'";
 mysqli_query($con,$sql5);
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