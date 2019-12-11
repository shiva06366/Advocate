<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->description)==='')
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $location = mysqli_real_escape_string($con, trim($request->data->location));
  $court_category = mysqli_real_escape_string($con, trim($request->data->court_category));
  $description = mysqli_real_escape_string($con, trim($request->data->description));

  // Update.
  $sql = "UPDATE `court` SET `name`='{$name}', `location`='{$location}', `court_category`='{$court_category}', `description`='{$description}' WHERE `id` = '{$id}' LIMIT 1";
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