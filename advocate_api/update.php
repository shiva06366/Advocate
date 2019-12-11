<?php
require 'connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if ((int)$request->data->id < 1 || trim($request->data->name) == '' || trim($request->data->description) == '' ) {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $description = mysqli_real_escape_string($con, trim($request->data->description));
  $date_time = mysqli_real_escape_string($con, $request->data->date_time);

  // Update.
  $sql = "UPDATE `to_do_list` SET `name`='$name', `description`='$description',`date_time`='$date_time' WHERE `id` = '{$id}' LIMIT 1";
  if(mysqli_query($con, $sql))
  {
    http_response_code(201);
	echo json_encode(['output'=>true]);
  }
  else
  {
    return http_response_code(422);
  }  
}