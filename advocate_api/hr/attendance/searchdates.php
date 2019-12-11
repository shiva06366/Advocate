<?php
require '../../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  
	
  // Sanitize.
  if(date ("Y-m-d",strtotime($request->data->date1))=='1970-01-01'){
	   $date_null=date("Y-m-d");
	 $date1  =  $date_null;
	 $date2  =  $date_null;
  }
  else{
  $date1 = mysqli_real_escape_string($con, strtotime($request->data->date1));
  $date2 = mysqli_real_escape_string($con, strtotime($request->data->date2));
  }
 
  $cr = 0;
for ($currentDate = $date1; $currentDate <= $date2;  
                                $currentDate += (86400)) { 
                                      
$Store = date('Y-m-d', $currentDate); 
$todolist[$cr]['date'] = $Store;
$cr++;
} 
echo json_encode(['data'=>$todolist]);
 //echo $sql;die();
  /*if($result =mysqli_query($con,$sql))
  {
	  $cr = 0;
	  while($row = mysqli_fetch_assoc($result))
		{

			
			$todolist[$cr]['date'] = $date;
			$cr++;
		}
		echo json_encode(['data'=>$todolist]);
  }
  else
  {
    http_response_code(422);
  }*/
}