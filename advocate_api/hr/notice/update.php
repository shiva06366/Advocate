<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->title) === '' || trim($request->data->description) === '')
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  $description = mysqli_real_escape_string($con, $request->data->description);
  $date_time = mysqli_real_escape_string($con, $request->data->date_time);


  // Update.
  $sql = "UPDATE `notice` SET `title`='{$title}', `description`='{$description}', `date_time`='{$date_time}' WHERE `id` = '{$id}' LIMIT 1";
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