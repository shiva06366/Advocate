<?php
require '../../connect.php';

// Get the posted data.
//$postdata = file_get_contents("php://input");
$hrn = json_decode($_POST['userEmp']);
//print_r($hrn);
//echo $hrn->name;
//print_r($_FILES);
//print_r($_FILES['filename']['name']);
if(!empty($_FILES))  
 {  
      $path =$_FILES['filename']['name'];  
	  if (move_uploaded_file($_FILES["filename"]["tmp_name"], $path)) {
        
    } else{
		
	}
 }
 else {
	$path ='null';
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
  $profile_pic = $path;
  $gender = mysqli_real_escape_string($con, $hrn->gender);
  $dob = mysqli_real_escape_string($con, $hrn->dob);
  $user_role=mysqli_real_escape_string($con, $hrn->user_role);
  $department=mysqli_real_escape_string($con, $hrn->dept_name);
  $designation=mysqli_real_escape_string($con, $hrn->designation);
  $doj=mysqli_real_escape_string($con, $hrn->doj);
  $join_salary=mysqli_real_escape_string($con, $hrn->join_salary);
  $email = mysqli_real_escape_string($con, $hrn->email);
  $username = mysqli_real_escape_string($con, $hrn->username);
  $password = md5(mysqli_real_escape_string($con, $hrn->password));
  $phone = mysqli_real_escape_string($con, $hrn->phone);
  $address = mysqli_real_escape_string($con, $hrn->address);
  $status=mysqli_real_escape_string($con, $hrn->stat);
  
  

    

  // Store.
  $sql = "INSERT INTO `employees`(`id`, `name`, `profile_pic`, `gender`, `dob`, `user_role`, `departments`, `designation`, `doj`, `join_salary`, `email`, `username`, `password`, `phone`, `address`, `status`, `added_by`) VALUES (null, '{$name}', '{$profile_pic}', '{$gender}', '{$dob}', '{$user_role}', '{$department}', '{$designation}', '{$doj}', '{$join_salary}', '{$email}','{$username}','{$password}','{$phone}','{$address}', '{$status}','1')";
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
	  'profile_pic'=>$profile_pic,
      'id'    => mysqli_insert_id($con),
	  'start' => "true"
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}