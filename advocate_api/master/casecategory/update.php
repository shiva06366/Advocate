<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->name) === '' )
  {
    return http_response_code(400);
  }
    
  // Sanitize.
  $id    = mysqli_real_escape_string($con, (int)$request->data->id);
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $parent_category = mysqli_real_escape_string($con, trim($request->data->parent_id));

  // Update.
  $sql = "UPDATE `case_categorys` SET `category_name`='{$name}', `parent_category`='{$parent_category}' WHERE `id` = '{$id}' LIMIT 1";
  $sql3 = "SELECT `id`, `category_name`  FROM `case_categorys` where id='{$id}'";
		  $result =mysqli_query($con, $sql3);
		  $row = mysqli_fetch_assoc($result);
		  $category_name=$row['category_name'];
		    $sql2 = "UPDATE `case_category` SET `category_name`='{$name}' WHERE `category_name` = '{$category_name}' LIMIT 1";
			//echo $sql2;die();
			mysqli_query($con, $sql2);
  if(mysqli_query($con, $sql))
  {

    http_response_code(201);
	echo json_encode(['output'=>true]);
  }
  else
  {
    return http_response_code(422);
  }  
}