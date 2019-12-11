<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Validate.
  if(trim($request->data->accountholdername) === '' || trim($request->data->account_number) === '' || trim($request->data->bank_name) === '' || trim($request->data->ifsc_code) === '' || trim($request->data->pan_number) === '' || trim($request->data->branch) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $accountholdername = mysqli_real_escape_string($con, trim($request->data->accountholdername));
  $account_number = mysqli_real_escape_string($con, trim($request->data->account_number));
  $bank_name = mysqli_real_escape_string($con, trim($request->data->bank_name));
  $ifsc_code = mysqli_real_escape_string($con, trim($request->data->ifsc_code));
  $pan_number = mysqli_real_escape_string($con, trim($request->data->pan_number));
  $branch = mysqli_real_escape_string($con, trim($request->data->branch));
  $userid = mysqli_real_escape_string($con, trim($request->data->userid));
// echo "userid".$userid;
  
  

    

  // Store.
  $sql = "INSERT INTO `bank`(`id`, `user_id`, `account_holder_name`, `account_number`, `bank_name`, `ifsc_code`, `pan_number`, `branch`) VALUES (null, '$userid', '{$accountholdername}', '{$account_number}', '{$bank_name}', '{$ifsc_code}', '{$pan_number}', '{$branch}')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'accountholdername' => $accountholdername,
      'account_number' => $account_number,
      'bank_name' => $bank_name,
      'ifsc_code' => $ifsc_code,
      'pan_number' => $pan_number,
      'branch' => $branch,
	  'userid' => $userid,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}