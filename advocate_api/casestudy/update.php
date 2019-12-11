<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if ((int)$request->data->id < 1 || trim($request->data->title) == '' || trim($request->data->notes) == '' || trim($request->data->result) == '') {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  $notes = mysqli_real_escape_string($con, $request->data->notes);
  $result = mysqli_real_escape_string($con, trim($request->data->result));
  $case_category_id = $request->data->case_category_id;
  $count_case_category_id = count( $request->data->case_category_id);

  // Update.
  $sql = "UPDATE `casestudy` SET `title`='$title', `notes`='$notes',`result`='$result'  WHERE `id` = '{$id}'";
  $sql2="DELETE FROM `casestudy_category` WHERE `casestudy_id` = '{$id}'";
  
  mysqli_query($con,$sql2);
  if(mysqli_query($con,$sql))
  {
	  for($i=0;$i<$count_case_category_id;$i++){
			$sql1="INSERT INTO `casestudy_category`(`id`, `casestudy_id`, `case_category_id`) VALUES (null,'{$id}', '{$request->data->case_category_id[$i]->item_id}')";
			
			mysqli_query($con,$sql1);
		}
  }
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