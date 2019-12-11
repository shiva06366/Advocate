<?php  
require '../../connect.php';
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
	 $request = json_decode($postdata);
	 if(trim($request->data->notes) === '' || trim($request->data->caseid) === '' || trim($request->data->close_date) === '')
  {
    return http_response_code(400);
  }
	// print_r($request);
	 $notes = mysqli_real_escape_string($con, trim($request->data->notes));
  $case_id = mysqli_real_escape_string($con, trim($request->data->caseid));
  $close_date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime( trim($request->data->close_date) ) ));
  // Store.
  $sql = "INSERT INTO `archivedcases`(`id`, `case_id`, `notes`, `close_date`) VALUES ( null, '{$case_id}', '{$notes}', '{$close_date}')";
  
  if(mysqli_query($con,$sql))
  {
	  $sql1="UPDATE `cases` SET `archived_cases` = '1' WHERE `cases`.`id` = '{$case_id}'";
	  mysqli_query($con, $sql1);
    http_response_code(201);
    $add = [
	  'notes' => $notes,
	  'case_id' => $case_id,
	  'close_date' => $close_date,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}
?>