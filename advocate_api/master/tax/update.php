<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->percent)==='')
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $tax_percent = mysqli_real_escape_string($con, trim($request->data->percent));

  // Update.
  $sql = "UPDATE `tax` SET `name`='{$name}', `tax_percent`='{$tax_percent}' WHERE `id` = '{$id}' LIMIT 1";
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