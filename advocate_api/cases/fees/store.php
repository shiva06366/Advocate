<?php
require '../../connect.php';
// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	//print_r($request);
  // Validate.
  if(trim($request->data->inv_no) === '' || trim($request->data->payment_mode_id) === '' || trim($request->data->date) === '' || trim($request->data->amount) === '' || trim($request->data->tax_id) === '' || trim($request->data->totalinv) === '' || trim($request->data->case_id) === '')
  {
    return http_response_code(400);
  }
  // Sanitize.
  $inv_no = mysqli_real_escape_string($con, trim($request->data->inv_no));
  $pay_mode = mysqli_real_escape_string($con, trim($request->data->payment_mode_id));
  $date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime(trim($request->data->date))));
  $amount = mysqli_real_escape_string($con, $request->data->amount);
  $tax = mysqli_real_escape_string($con, $request->data->tax_id);
  $tot_amt = mysqli_real_escape_string($con, $request->data->totalinv);
  $case_id = mysqli_real_escape_string($con, $request->data->case_id);
  $invoice_date = mysqli_real_escape_string($con, date( 'Y-m-d', strtotime(trim($request->data->date))));
  // Store.
  $sql = "INSERT INTO `invoice`(`inv_no`, `case_id`, `pay_mode`, `date`, `amount`, `tax`, `tot_amt`, `invoice_date`) VALUES (null, '{$case_id}', '{$pay_mode}', '{$date}', '{$amount}', '{$tax}', '{$tot_amt}', '{$invoice_date}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
      'case_id' => $case_id,
	  'pay_mode' => $pay_mode,
	  'date' => $date,
	  'amount' => $amount,
	  'tax' => $tax,
	  'tot_amt' => $tot_amt,
	  'invoice_date' => $invoice_date,
      'inv_no'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}