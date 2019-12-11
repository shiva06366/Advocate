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
  if(trim($request->data->title) === '' || trim($request->data->case_no) === '' || trim($request->data->client_id) === ''|| trim($request->data->location_id) === '' || trim($request->data->court_category_id) === '' || trim($request->data->court_id) === '' || trim($request->data->case_category_id) === '' || trim($request->data->case_stage_id) === '' || trim($request->data->selectedItems) === '' || trim($request->data->description) === '' || trim($request->data->start_date) === '' || trim($request->data->hearing_date) === '' || trim($request->data->o_lawyer) === '' || trim($request->data->fees) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $title = mysqli_real_escape_string($con, trim($request->data->title));
  $case_no = mysqli_real_escape_string($con, trim($request->data->case_no));
  $client_id = mysqli_real_escape_string($con, trim($request->data->client_id));
  $location_id = mysqli_real_escape_string($con, trim($request->data->location_id));
  $court_category_id = mysqli_real_escape_string($con, trim($request->data->court_category_id));
  $court_id = mysqli_real_escape_string($con, trim($request->data->court_id));
  $case_category_id = $request->data->case_category_id;
  $case_stage_id = mysqli_real_escape_string($con, trim($request->data->case_stage_id));
  $act_id = $request->data->selectedItems;
  $description = mysqli_real_escape_string($con, trim($request->data->description));
  $start_date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime( trim($request->data->start_date) ) ));
  $hearing_date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime( trim($request->data->hearing_date) ) ));
  $o_lawyer = mysqli_real_escape_string($con, trim($request->data->o_lawyer));
  $fees = mysqli_real_escape_string($con, trim($request->data->fees));
 
$count_case_category_id = count( $request->data->case_category_id);
$count_selectedItems=count($request->data->selectedItems);
  // Store.
  $sql = "INSERT INTO `cases`(`id`, `case_title`, `case_no`, `client_name`, `location`,  `court`, `court_category`, `case_stage`, `description`, `filling_date`, `hearing_date`, `apposite_lawyer`, `total_fees`, `updated_by`, `starred_cases`, `archived_cases`) VALUES (null,'{$title}', '{$case_no}', '{$client_id}', '{$location_id}', '{$court_id}', '{$court_category_id}', '{$case_stage_id}', '{$description}', '{$start_date}', '{$hearing_date}', '{$o_lawyer}', '{$fees}', 1, '', '')";
 // echo $sql;die();
  if(mysqli_query($con,$sql))
  {
	  $last_id = $con->insert_id;
	  for($i=0;$i<$count_case_category_id;$i++){
			$sql1="INSERT INTO `cases_case_category`(`id`, `case_id`, `case_category_id`) VALUES (null,'{$last_id}', {$request->data->case_category_id[$i]->item_id})";
			mysqli_query($con,$sql1);
		}
		for($j=0;$j<$count_selectedItems;$j++){
			$sql2="INSERT INTO `cases_act`(`id`, `case_id`, `act_id`) VALUES (null,'{$last_id}', {$request->data->selectedItems[$j]->item_id})";
			mysqli_query($con,$sql2);
		}
    http_response_code(201);
    $add = [
	  'case_title' => $title,
      'case_no' => $case_no,
      'client_id' => $client_id,
	  'location_id' => $location_id,
	  'court_category_id'=>$court_category_id,
	  'court_id'=>$court_id,
	  'case_stage_id'=>$case_stage_id,
	  'description'=>$description,
	  'start_date'=>$start_date,
	  'hearing_date'=>$hearing_date,
	  'o_lawyer'=>$o_lawyer,
	  'fees'=>$fees,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}