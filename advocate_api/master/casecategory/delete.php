<?php

require '../../connect.php';

// Extract, validate and sanitize the id.
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}

// Delete.
$sql = "SELECT `id`, `category_name`, `parent_category` FROM `case_categorys` where id='{$id}'";
//echo $sql;die();
if($result =mysqli_query($con, $sql))
{
	 $row = mysqli_fetch_assoc($result);
	 $category_name=$row['category_name'];
	 if($row['parent_category']==''){

		 $sql1="Delete from case_category where category_name='{$category_name}'";
		 mysqli_query($con, $sql1);
		 $sql2="Delete from case_categorys where id='{$id}'";
		 mysqli_query($con, $sql2);
		 $sql3="UPDATE `case_categorys` SET `parent_category` = '' WHERE `parent_category` = '{$category_name}'";
		 mysqli_query($con, $sql3);
	 }
	 else{

		 $sql1="Delete from case_category where category_name='{$category_name}'";
		 
		 $sql2="Delete from case_categorys where id='{$id}'";
		
		 mysqli_query($con, $sql2);
		 mysqli_query($con, $sql1);
		 
	 }
  http_response_code(201);
  echo json_encode(['output'=>true]);
}
else
{
  return http_response_code(422);
}
?>