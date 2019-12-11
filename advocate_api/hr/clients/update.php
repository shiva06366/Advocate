<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->gender) === '' || trim($request->data->email) === '' || trim($request->data->username) === '' || trim($request->data->phone) === '' || trim($request->data->address) === '')
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  $gender = mysqli_real_escape_string($con, $request->data->gender);
  $dob = mysqli_real_escape_string($con, $request->data->dob);
  $email = mysqli_real_escape_string($con, $request->data->email);
  $username = mysqli_real_escape_string($con, $request->data->username);
  $password = md5(mysqli_real_escape_string($con, $request->data->password));
  $phone = mysqli_real_escape_string($con, $request->data->phone);
  $address = mysqli_real_escape_string($con, $request->data->address);


  // Update.
  $sql = "UPDATE `employees` SET `name`='{$name}', `gender`='{$gender}', `dob`='{$dob}', `email`='{$email}', `username`='{$username}', `password`='{$password}', `phone`='{$phone}', `address`='{$address}' WHERE `id` = '{$id}' LIMIT 1";
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