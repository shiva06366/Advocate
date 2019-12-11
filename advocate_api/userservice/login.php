<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");
	
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Sanitize.
  $email = mysqli_real_escape_string($con, trim($request->data->email));
  $password = md5(mysqli_real_escape_string($con, trim($request->data->password)));
  // Store.
  $sql = "SELECT `id`, `email`, `username`, `password`, `user_role` FROM `employees` WHERE  email='{$email}' and password='{$password}' ";
  if($result =mysqli_query($con,$sql))
  {
	  
	$cr = 0;
	while($row = mysqli_fetch_assoc($result))
  {
	$todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['email'] = $row['email'];
    $todolist[$cr]['username']   = $row['username'];
    $todolist[$cr]['password']   = $row['password']; 
    $todolist[$cr]['user_role']   = $row['user_role']; 
	$todolist[$cr]['start'] = true;
	$cr++;
  }
  echo json_encode(['data'=>$todolist]);
    
   
  }
  else
  {
    http_response_code(422);
  }
}
else {
	echo "values not entered";
}