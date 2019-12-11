<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->user_type) === '' || trim($request->data->description) === '')
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $user_type = mysqli_real_escape_string($con, trim($request->data->user_type));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  $description = mysqli_real_escape_string($con, $request->data->description);


  // Update.

  
  $sql = "UPDATE `user_role` SET `user_type`='{$user_type}',`description`='{$description}' WHERE `id` = '{$id}' LIMIT 1";
  //echo $sql;die();
  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}