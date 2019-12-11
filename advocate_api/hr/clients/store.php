<?php
require '../../connect.php';

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
  if(trim($hrn->name) === '' || trim($hrn->gender) === '' || trim($hrn->email) === '' || trim($hrn->username) === '' || trim($hrn->phone) === '' || trim($hrn->address) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($hrn->name));
  //$profile_pic = mysqli_real_escape_string($con, trim($hrn->profile_pic));
  $gender = mysqli_real_escape_string($con, $hrn->gender);
  $dob = mysqli_real_escape_string($con, $hrn->dob);
  $email = mysqli_real_escape_string($con, $hrn->email);
  $username = mysqli_real_escape_string($con, $hrn->username);
  $password = md5(mysqli_real_escape_string($con, $hrn->password));
  $phone = mysqli_real_escape_string($con, $hrn->phone);
  $address = mysqli_real_escape_string($con, $hrn->address);
  $img=$path;
  

    

  // Store.
  $sql = "INSERT INTO `employees`(`id`, `name`, `profile_pic`, `gender`, `dob`, `email`, `username`, `password`, `phone`, `address`,`user_role`) VALUES (null,'{$name}','{$img}','{$gender}','{$dob}','{$email}','{$username}','{$password}','{$phone}','{$address}','3')";
//echo $sql;die();
  if(mysqli_query($con,$sql))
  {
	  
    http_response_code(201);
    $add = [
	  'name' => $name,
      'gender' => $gender,
      'dob' => $dob,
      'email' => $email,
      'username' => $username,
      'password' => $password,
      'phone' => $phone,
      'address' => $address,
	  'profile_pic'=>$img,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}