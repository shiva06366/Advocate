<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->description) === '')
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  $description = mysqli_real_escape_string($con, $request->data->description);
  $designations = mysqli_real_escape_string($con, $request->data->designations);
//echo $designations;
$designations_arr = explode (",", $designations);
$sql2= "DELETE FROM `dept_designation` WHERE `sr_no` ='{$id}'";
mysqli_query($con, $sql2);
foreach($designations_arr as $value){
    $sql3= "INSERT INTO `dept_designation`(`id`, `sr_no`, `designation`) VALUES (null,'{$id}', '{$value}')";
	
	mysqli_query($con,$sql3);
}	
  // Update.
  $sql = "UPDATE `departments` SET `dept_name`='{$name}', `dept_description`='{$description}' WHERE `id` = '{$id}' LIMIT 1";

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