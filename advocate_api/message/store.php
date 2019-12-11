<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  // Validate.
  if(trim($request->data->message) === '' || trim($request->data->login_id)=== '' || trim($request->data->userid)=== '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $message = mysqli_real_escape_string($con, trim($request->data->message));
  $login_id = mysqli_real_escape_string($con, trim($request->data->login_id));
  $userid = mysqli_real_escape_string($con, trim($request->data->userid));
  
  // Store.
  $sql = "INSERT INTO `message_user`(`id`, `user_from`, `user_to`, `message`) VALUES(null, '{$login_id}', '{$userid}', '{$message}')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'message' => $message,
	  'user_to'=>$user_to,
	  'user_from'=>$login_id,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add]);
  }
  else
  {
    http_response_code(422);
  }
}