<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if ((int)$request->data->id < 1 || trim($request->data->title) == '' || trim($request->data->name) == '' || trim($request->data->motive) == '' || trim($request->data->notes) == '') {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $title = mysqli_real_escape_string($con, trim($request->data->title));

  $motive = mysqli_real_escape_string($con, trim($request->data->motive));
  $name = mysqli_real_escape_string($con, $request->data->name);
  $notes = mysqli_real_escape_string($con, $request->data->notes);
  $date_time = mysqli_real_escape_string($con, $request->data->date_time);
  // Update.
  $sql = "UPDATE `appointment` SET `title`='{$title}',`contact`='{$name}',`motive`='{$motive}',`date_time`='{$date_time}',`notes`='{$notes}' WHERE `id` = '{$id}'";
  //echo $sql;die();
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