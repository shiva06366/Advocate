<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->percent)=== '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $tax_percent = mysqli_real_escape_string($con, trim($request->data->percent));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  // Store.
  $sql = "INSERT INTO `tax`(`id`, `name`, `tax_percent`) VALUES (null,'{$name}','{$tax_percent}')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'name' => $name,
	  'tax_percent'=>$tax_percent,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}