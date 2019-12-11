<?php
/**
 * Returns the list of cars.
 */
require '../../connect.php';
$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? mysqli_real_escape_string($con, (int)$_GET['id']) : false;

if(!$id)
{
  return http_response_code(400);
}    
$todolist = [];
$sql = "SELECT id,name,profile_pic,gender,dob,user_role,departments,designation,doj,join_salary,email,username,phone,address,status FROM employees WHERE `id` ='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $d_id=$row['departments'];
	  $desig_id=$row['designation'];
	  $sql1="SELECT dept_name FROM `departments` where id= '{$d_id}'";
	  $result1=mysqli_query($con,$sql1);
	  $row1=mysqli_fetch_assoc($result1);
	  $sql2="SELECT designation FROM `dept_designation` WHERE id='{$desig_id}'";
	  $result2=mysqli_query($con,$sql2);
	  $row2=mysqli_fetch_assoc($result2);
	  
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['name'] = $row['name'];
	$todolist[$cr]['gender'] = $row['gender'];
	$todolist[$cr]['dob'] = $row['dob'];
	$todolist[$cr]['user_role'] = $row['user_role'];
	$todolist[$cr]['departments'] = $row1['dept_name'];
	$todolist[$cr]['designation'] = $row2['designation'];
	$todolist[$cr]['doj'] = $row['doj'];
	$todolist[$cr]['join_salary'] = $row['join_salary'];
	$todolist[$cr]['email'] = $row['email'];
	$todolist[$cr]['username'] = $row['username'];
    $todolist[$cr]['phone']   = $row['phone'];
    $todolist[$cr]['address']   = $row['address'];
    $todolist[$cr]['status']   = $row['status'];
    $todolist[$cr]['profile_pic']   = $row['profile_pic'];
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
