<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
$len=sizeof($request);
  // Sanitize.
  for($i=0;$i<=$len;$i++){
  $id = mysqli_real_escape_string($con, trim($request->data[$i]->id));
  $user_type = mysqli_real_escape_string($con, $request->data[$i]->user_type);
  for($j=1;$j<=143;$j++)
  {
	  $accessall= "access".$j;
	  
	  $aj="a".$j;
	  $aj=mysqli_real_escape_string($con, $request->data[$i]->access->$accessall);
	  if($aj==1){
		  $value = 'true';
	  }
	  else {
		  $value = 'false';
	  }
	  $sql = "UPDATE `adpermission` SET `$accessall`='{$value}' WHERE user_id='{$id}'";
	  
//  echo $aj."</br>";
  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    //echo json_encode(['output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
  }
    

  // Store.
  

  }


  
}