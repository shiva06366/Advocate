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
  $date1 = mysqli_real_escape_string($con, date ("Y-m-d",strtotime($request->data->date1)));
  $date2 = mysqli_real_escape_string($con, date ("Y-m-d",strtotime($request->data->date2)));
  $employee_id = mysqli_real_escape_string($con, trim($request->data->employee_id));
  $date_null=date("Y-m-d");
  if($employee_id==''){
	  $sql="SELECT id,user_id FROM user_timing group by user_id";
  }
  else{
	  $sql="SELECT id,user_id FROM user_timing where user_id='{$employee_id}' group by user_id";
  }
  

 //echo $sql;die();
  if($result =mysqli_query($con,$sql))
  {
	  $cr = 0;
	  while($row = mysqli_fetch_assoc($result))
		{
			$user_id= $row['user_id'];
			$sql1="SELECT `id`, `name` FROM `employees` WHERE id= '{$user_id}'";
			$result1=mysqli_query($con,$sql1);
			$row1=mysqli_fetch_assoc($result1);
			$todolist[$cr]['id']      = $row['id'];
			$todolist[$cr]['name'] = $row1['name'];
			if($date1=='1970-01-01' and $date2=='1970-01-01')
			{
				$sql1="SELECT id,date,time FROM user_timing where date between '{$date_null}' AND '{$date_null}' and user_id='{$user_id}'  order by date asc";
			}
			elseif($date1!='' and $date2!='')
			{
				$sql1="SELECT id,date,time FROM user_timing WHERE date between '{$date1}' AND '{$date2}'and user_id='{$user_id}'  order by date asc";
			}
			if($result1 =mysqli_query($con,$sql1))
			{
				//echo $sql1;die();
				$cr1 = 0;
				while($row2 = mysqli_fetch_assoc($result1))
				{
					$todolist[$cr]['datas'][$cr1]['date'] = $row2['date'];
					$todolist[$cr]['datas'][$cr1]['time'] = $row2['time'];
					$cr1++;
				}
 
				
			}
			$cr++;
		}
		echo json_encode(['data'=>$todolist]);
  }
  else
  {
    http_response_code(422);
  }
}