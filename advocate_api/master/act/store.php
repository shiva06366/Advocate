<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->description)=== '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $description = mysqli_real_escape_string($con, trim($request->data->description));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  // Store.
  $sql = "INSERT INTO `act`(`id`, `name`, `description`) VALUES (null,'{$name}','{$description}')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'name' => $name,
	  'description'=>$description,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}