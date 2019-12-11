<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if ((int)$request->data->id < 1 || trim($request->data->name) == '' || trim($request->data->email) == '' || trim($request->data->address) == '') {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $email = mysqli_real_escape_string($con, $request->data->email);
  $phone = mysqli_real_escape_string($con, trim($request->data->phone));
  $address = mysqli_real_escape_string($con, $request->data->address);

  // Update.
  $sql = "UPDATE `contact` SET `name`='$name', `email`='$email',`phone`='$phone' ,`address`='$address' WHERE `id` = '{$id}'";
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