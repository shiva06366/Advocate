<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
//	print_r($request);

  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->description) === '')
  {
    return http_response_code(400);
  }


  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $description = mysqli_real_escape_string($con, $request->data->description);
  $designations=$request->data->designations;
  //print_r($designations);
  
  

    

  // Store.
  $sql = "INSERT INTO `departments`(`id`, `dept_name`, `dept_description`) VALUES (null, '{$name}', '{$description}')";
  //echo $sql;
  if(mysqli_query($con,$sql))
  {
	  $sr_id= mysqli_insert_id($con);
	  foreach($request->data->designations as $value){
    $sql2= "INSERT INTO `dept_designation`(`id`, `sr_no`, `designation`) VALUES (null,'{$sr_id}', '{$value}')";
	
	mysqli_query($con,$sql2);
}	
	  
    http_response_code(201);
    $add = [
	  'dept_name' => $title,
      'dept_description' => $description,
	  'dept_designation' => $designations,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
  
}