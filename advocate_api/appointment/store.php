<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  if(trim($request->data->title) === '' || trim($request->data->name) === '' || trim($request->data->motive) === ''|| trim($request->data->notes) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  $name = mysqli_real_escape_string($con, $request->data->name);
  $motive = mysqli_real_escape_string($con, trim($request->data->motive));
  $date_time = mysqli_real_escape_string($con, trim($request->data->date_time));
  $notes = mysqli_real_escape_string($con, $request->data->notes);
  

  // Store.
  $sql = "INSERT INTO `appointment`(`title`, `contact`, `motive`, `date_time`, `notes`, `added_by`) VALUES ('{$title}','{$name}','{$motive}','{$date_time}','{$notes}',1)";
//  echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'title' => $title,
	  'contact' => $name,
      'motive' => $motive,
      'date_time' => $date_time,
	  'notes' => $notes,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}