<?php
/**
 * Returns the list of cars.
 */
require '../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}       
$todolist = [];
$today_date=date("Y-m-d");

$sql = "SELECT count(*) as countava FROM `markin` where user_id='$id' and date='$today_date'";

$result = mysqli_query($con,$sql);

$row = mysqli_fetch_assoc($result);



if($result = mysqli_query($con,$sql))
{
	$tcount=$row['countava'];
	$fcount=$tcount%2;
  $cr = 0;

    $todolist[$cr]['countava']   	= $fcount;
    $cr++;
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
