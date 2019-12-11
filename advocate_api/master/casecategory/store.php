<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->data->name) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $parent_name = mysqli_real_escape_string($con, trim($request->data->parent_id));
	if($parent_name==''){
  // Store.
  $sql = "INSERT INTO `case_category`(`id`, `category_name`) VALUES (null,'{$name}')";
  if(mysqli_query($con,$sql))
  {
	  $sql1="INSERT INTO `case_categorys`(`id`, `category_name`, `parent_category`) VALUES (null,'{$name}', '{$parent_name}')";
	  mysqli_query($con,$sql1);
	 
    http_response_code(201);
    $add = [
	  'category_name' => $name,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$todolist,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
	}
	else {
		$sql2 = "INSERT INTO `case_category`(`id`, `category_name`) VALUES (null,'{$name}')";
	  mysqli_query($con,$sql2);
$sql = "INSERT INTO `case_categorys`(`id`, `category_name`, `parent_category`) VALUES (null,'{$name}', '{$parent_name}')";
  if(mysqli_query($con,$sql))
  {
	   
    http_response_code(201);
    $add = [
	  'category_name' => $name,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$todolist,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
		
	}
}