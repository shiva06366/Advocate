<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
 // print_r($request->data->court_category_id[0]);
// print_r($request[0]->data->court_category_id);
  // Validate.
  if(trim($request->data->title) === '' || trim($request->data->notes) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  $result = mysqli_real_escape_string($con, trim($request->data->result));
  $notes = mysqli_real_escape_string($con, trim($request->data->notes));
  $case_category_id = $request->data->case_category_id;
 
$count_case_category_id = count( $request->data->case_category_id);
  // Store.
  $sql = "INSERT INTO `casestudy`(`id`, `title`,`result`, `notes`) VALUES (null,'{$title}', '{$result}', '{$notes}')";
 // echo $sql;die();
  if(mysqli_query($con,$sql))
  {
	  $last_id = $con->insert_id;
	  for($i=0;$i<$count_case_category_id;$i++){
			$sql1="INSERT INTO `casestudy_category`(`id`, `casestudy_id`, `case_category_id`) VALUES (null,'{$last_id}', {$request->data->case_category_id[$i]->item_id})";
			mysqli_query($con,$sql1);
		}
    http_response_code(201);
    $add = [
	  'title`' => $title,
      'result' => $result,
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