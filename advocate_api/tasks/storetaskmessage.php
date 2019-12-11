<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
 // print_r($request->data->court_category_id[0]);
// print_r($request[0]->data->court_category_id);
  // Validate.
  if(trim($request->data->message) === '' || trim($request->data->task_id) === '' || trim($request->data->userId) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $message = mysqli_real_escape_string($con, trim($request->data->message));
  $task_id = mysqli_real_escape_string($con, trim($request->data->task_id));
  $userId = mysqli_real_escape_string($con, trim($request->data->userId));
 
  // Store.
  $sql = "INSERT INTO `task_message` (`id`, `task_id`, `msg_from`, `message`, `date`) VALUES (Null, '{$task_id}', '{$userId}', '{$message}', CURRENT_TIMESTAMP);";
  if(mysqli_query($con,$sql))
  {

    http_response_code(201);
    $add = [
	  'task_id' => $task_id,
      'message' => $message,
      'userId' => $userId,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add]);
  }
  else
  {
    http_response_code(422);
  }
}