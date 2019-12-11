<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");
// print_r($_POST);
//print_r($postdata->userEmp);
//print_r($_POST['userEmp']);
$hrn = json_decode($_POST['userEmp']);
//print_r($hrn);
//echo $hrn->name;

if(!empty($_FILES))  
 {  
      $path = $_FILES['filename']['name'];  
	  if (move_uploaded_file($_FILES["filename"]["tmp_name"], $path)) {
        
    } else{
		
	}
 }
 else {


 }
if(isset($hrn) && !empty($hrn))
{
  // Extract the data.

	

  // Validate.
  if(trim($hrn[0]->name) === '' || trim($hrn[0]->email) === '' || trim($hrn[0]->username) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $id = mysqli_real_escape_string($con, trim($hrn[0]->id));
  $name = mysqli_real_escape_string($con, trim($hrn[0]->name));
  $email = mysqli_real_escape_string($con, $hrn[0]->email);
  $username = mysqli_real_escape_string($con, $hrn[0]->username);
  $password = md5(mysqli_real_escape_string($con, $hrn[0]->password));
  $img=$path;
  

    
  // Store.
  $sql = "UPDATE `employees` SET `name`= '{$name}', `profile_pic`='{$img}', `email`='{$email}', `username`='{$username}',`password`='{$password}'  WHERE `id`='{$id}'";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
	  
    http_response_code(201);
    $add = [
	  'name' => $name,
      'email' => $email,
      'username' => $username,
      'password' => $password,
	  'profile_pic'=>$img,
      'id'    =>$id
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}