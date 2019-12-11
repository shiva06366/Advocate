<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  if(trim($request->data->leavetype) === '' || trim($request->data->description) === '' || trim($request->data->leaves) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $leavetype = mysqli_real_escape_string($con, trim($request->data->leavetype));
  //$profile_pic = mysqli_real_escape_string($con, trim($request->data->profile_pic));
  $description = mysqli_real_escape_string($con, $request->data->description);
  $leaves = mysqli_real_escape_string($con, $request->data->leaves);

  // Store.
  $sql = "INSERT INTO `leaves`(`id`, `leavetype`, `description`, `leaves`) VALUES (null,'{$leavetype}','{$description}','{$leaves}')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'leavetype' => $leavetype,
      'description' => $description,
      'leaves' => $leaves,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}