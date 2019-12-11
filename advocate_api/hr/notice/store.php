<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  if(trim($request->data->title) === '' || trim($request->data->description) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  $description = mysqli_real_escape_string($con, $request->data->description);
  $date_time=mysqli_real_escape_string($con, $request->data->date_time);
  
  

    

  // Store.
  $sql = "INSERT INTO `notice`(`id`, `title`, `description`, `date_time`) VALUES (null, '{$title}', '{$description}', '{$date_time}')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'title' => $title,
      'description' => $description,
      'date_time' => $date_time,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}