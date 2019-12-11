<?php
require '../../connect.php';
// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
//	print_r($request);
  // Validate.
  if(trim($request->data->is_case) === '' || trim($request->data->name) === '')
  {
    return http_response_code(400);
  }
  // Sanitize.
  $type = mysqli_real_escape_string($con, trim($request->data->is_case));
  $case_name = mysqli_real_escape_string($con, $request->data->case_id);
  $title = mysqli_real_escape_string($con, $request->data->name);
  //print_r($designations);
  // Store.
  $sql = "INSERT INTO `adddocuments`(`id`, `type`, `case_name`, `title`) VALUES (null, '{$type}', '{$case_name}','{$title}')";
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'type' => $type,
      'case_name' => $case_name,
	  'title' => $title,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}