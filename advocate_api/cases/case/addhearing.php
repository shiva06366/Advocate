<?php

require '../../connect.php';

// Extract, validate and sanitize the id.
$hrn = json_decode($_POST['userEmp']);

//echo $hrn->name;

if(!empty($_FILES))  
 {  
      $path = $_FILES['filename']['name'];  
	  if (move_uploaded_file($_FILES["filename"]["tmp_name"], $path)) {
        
    } else{
		
	}
 }
 else {
	$path ='null';
 }
 
 if(isset($hrn) && !empty($hrn))
{
	
  // Sanitize.
  $nextdate = mysqli_real_escape_string($con, trim($hrn->nextdate));
  $hearing_docs = $path;
  $lastdate = mysqli_real_escape_string($con, $hrn->lastdate);
  $notes = mysqli_real_escape_string($con, $hrn->notes);
  $case_id = mysqli_real_escape_string($con, $hrn->case_id);
  
  

    

  // Store.
  $sql = "INSERT INTO `hearingdates`(`id`, `case_id`, `next_date`, `last_date`, `notes`, `hearing_docs`) VALUES (null, '{$case_id}', '{$nextdate}', '{$lastdate}', '{$notes}', '{$hearing_docs}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $add = [
	  'case_id' => $case_id,
      'nextdate' => $nextdate,
      'lastdate' => $lastdate,
      'notes' => $notes,
      'hearing_docs' => $hearing_docs,
	  'start' => "true"
    ];
    echo json_encode(['data'=>$add]);
  }
  else
  {
    http_response_code(422);
  }
}
?>