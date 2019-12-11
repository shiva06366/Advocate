<?php
require '../../connect.php';

// Get the posted data.
//$postdata = file_get_contents("php://input");
$hrn = json_decode($_POST['userEmp']);
//print_r($hrn);die();
//echo $hrn->name;

if(!empty($_FILES))  
 {  
      $path = './uploads/'.$_FILES['filename']['name'];  
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
  if(trim($hrn->title) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $title = mysqli_real_escape_string($con, trim($hrn->title));
  $user_id = mysqli_real_escape_string($con, trim($hrn->userid));
  $attachment = $path;

  // Store.
  $sql = "INSERT INTO `adddocument_manage`(`id`, `document_id`, `document_name`, `document_file` ) VALUES (null, '{$user_id}', '{$title}', '{$attachment}')";
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'document_name' => $title,
	  'document_id' => $user_id,
	  'document_file'=>$attachment,
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