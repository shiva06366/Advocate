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
$sql = "SELECT `id`, `title`,`result`, `notes` FROM `casestudy` where id='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
$row = mysqli_fetch_assoc($result);
	 
   $todolist[$cr]['id']      = $row['id'];
   $casestudy_id=$row['id'];
   $sql1="select `id`, `casestudy_id`, `case_category_id` from casestudy_category where casestudy_id='{$casestudy_id}'";
   
   $result1=mysqli_query($con,$sql1);
   $category_name='';
   while($row1=mysqli_fetch_assoc($result1))
   {
	   $case_category_id= $row1['case_category_id'];
	   $sql2="SELECT `id`, `category_name` FROM `case_category` where id='{$case_category_id}'";
	   
	   $result2=mysqli_query($con,$sql2);
	   $row2=mysqli_fetch_assoc($result2);
	   $cat_name=$row2['category_name'];
	   $category_name = rtrim(ltrim($category_name.",". $cat_name,","));
   }

	$todolist[$cr]['title'] = $row['title'];
    $todolist[$cr]['result']   = $row['result'];
    $todolist[$cr]['notes']   = $row['notes'];
	$todolist[$cr]['category_name']=$category_name;
    $cr++;
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
