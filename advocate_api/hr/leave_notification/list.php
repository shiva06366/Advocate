<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
    
$todolist = [];
$sql = "SELECT `id`, `user_id`, `date`, `leave_type`, `reason`, `status`, `approve_date` FROM `apply_leave`";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
   $user_id=$row['user_id'];
   $leave_type=$row['leave_type'];
   $sql2="SELECT `id`, `name` FROM `employees` WHERE id='{$user_id}'";
   $result2 = mysqli_query($con,$sql2);
   $row2 = mysqli_fetch_assoc($result2);
   $sql3="SELECT `id`, `leavetype`  FROM `leaves` WHERE id='{$leave_type}'";
   $result3 = mysqli_query($con,$sql3);
   $row3 = mysqli_fetch_assoc($result3);   
   $todolist[$cr]['id']      			= $row['id'];
   $todolist[$cr]['user_id']      		= $row2['name'];
   $todolist[$cr]['date']      			= $row['date'];
   $todolist[$cr]['leave_type']      	= $row3['leavetype'];
   $todolist[$cr]['reason']      		= $row['reason'];
   $todolist[$cr]['status']      		= $row['status'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
