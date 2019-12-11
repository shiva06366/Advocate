<?php
require '../connect.php';
// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	//print_r($request);
  // Validate.
  if(trim($request->data->date) === '' || trim($request->data->leave_id) === '' || trim($request->data->reason) === '' || trim($request->data->userId) === '')
  {
    return http_response_code(400);
  }
  // Sanitize.
  $date = mysqli_real_escape_string($con, trim($request->data->date));
  $leave_id = mysqli_real_escape_string($con, $request->data->leave_id);
  $reason = mysqli_real_escape_string($con, $request->data->reason);
  $userId = mysqli_real_escape_string($con, $request->data->userId);
  //print_r($designations);
  // Store.
  $sql = "INSERT INTO `apply_leave`(`id`, `user_id`, `date`, `leave_type`, `reason`) VALUES (null,'{$userId}', '{$date}', '{$leave_id}', '{$reason}')";
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'userId' => $userId,
      'date' => $date,
	  'leave_id' => $leave_id,
	  'reason' => $reason,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}