
<?php
require '../../connect.php';
// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	//print_r($request);die();
  // Validate.
  if(trim($request->data->fees_id) === '' | trim($request->data->r_date) === '' || trim($request->data->r_amount) === ''|| trim($request->data->case_id) === '')
  {
    return http_response_code(400);
  }
  // Sanitize.
  $inv_no = mysqli_real_escape_string($con, trim($request->data->fees_id));
  $date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime(trim($request->data->r_date))));
  $amount = mysqli_real_escape_string($con, $request->data->r_amount);
  $case_id = mysqli_real_escape_string($con, $request->data->case_id);
  $receipt_date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime(trim($request->data->r_date))));
  // Store.
  $sql = "INSERT INTO `receipt`(`rec_id`, `inv_no`, `case_id`, `date`, `amount`, `receipt_date`) VALUES (null, '{$inv_no}', '{$case_id}', '{$date}', '{$amount}', '{$receipt_date}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
      'case_id' => $case_id,
	  'date' => $date,
	  'amount' => $amount,
	  'receipt_date' => $receipt_date,
      'inv_no'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}