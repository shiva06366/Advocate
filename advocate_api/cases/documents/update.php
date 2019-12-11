<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
 // print_r($request->data->court_category_id[0]);
// print_r($request[0]->data->court_category_id);
  // Validate.
  if(trim($request->data->title) === '' || trim($request->data->is_case) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $id=mysqli_real_escape_string($con, trim($request->data->id));
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  $is_case = mysqli_real_escape_string($con, trim($request->data->is_case));
  $case_id = mysqli_real_escape_string($con, trim($request->data->case_id));
if($is_case=='case'){
  $sql = "UPDATE  `adddocuments` SET `type`='{$is_case}',`case_name`='{$case_id}',`title`='{$title}' WHERE `id`='{$id}'";
}
else {
	$sql = "UPDATE  `adddocuments` SET `type`='{$is_case}',`case_name`='',`title`='{$title}' WHERE `id`='{$id}'";
}
//echo $sql;
 if(mysqli_query($con,$sql))
  {
	  
    http_response_code(201);
	echo json_encode(['output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
 
}