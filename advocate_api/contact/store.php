<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->email) === '' || trim($request->data->address) === ''|| trim($request->data->phone) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $phone = mysqli_real_escape_string($con, $request->data->phone);
  $email = mysqli_real_escape_string($con, trim($request->data->email));
  $address = mysqli_real_escape_string($con, $request->data->address);
  

  // Store.
  $sql = "INSERT INTO `contact`(`id`, `name`, `phone`,`email`,`address`,`added_by`) VALUES (null,'{$name}','{$phone}','{$email}','{$address}',1)";
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'name' => $name,
      'phone' => $phone,
      'email' => $email,
	  'address' => $address,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}