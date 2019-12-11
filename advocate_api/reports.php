<?php
require 'connect.php';
$sql_total="SELECT SUM(total_fees) as total_case_amount FROM `cases`";
$result_total = mysqli_query($con,$sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$sql_reciept="SELECT sum(amount) as total_receipt FROM `receipt`";
$result_reciept = mysqli_query($con,$sql_reciept);
$row_reciept = mysqli_fetch_assoc($result_reciept);
$sql_invoice="SELECT sum(tot_amt) as total_invoice FROM `invoice`";
$result_invoice = mysqli_query($con,$sql_invoice);
$row_invoice = mysqli_fetch_assoc($result_invoice);

$total_amt=$row_total['total_case_amount'];
$invoice_amt=$row_invoice['total_invoice'];
$recieved_amt=$row_reciept['total_receipt'];
$total_pending=$total_amt-$recieved_amt;
//echo $total_amt," ".$invoice_amt." ".$recieved_amt." ".$total_pending;
$dataPoints = array(
	array("label"=> "Total Case Amount", "y"=> $total_amt),
	array("label"=> "Invoice Raise", "y"=> $invoice_amt),
	array("label"=> "Received amount", "y"=> $recieved_amt),
	array("label"=> "Total Pending", "y"=> $total_pending)
	);
echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
?>