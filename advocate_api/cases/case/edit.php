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
$sql = "SELECT `id`, `case_title`, `case_no`, `client_name`, `location`, `court_category`, `court`, `case_stage`, `description`, `filling_date`, `hearing_date`, `apposite_lawyer`, `total_fees` FROM `cases` WHERE `id` ='{$id}'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
	  $client_no=$row['client_name'];
	  $loc=$row['location'];
	  $cou_cat=$row['court_category'];
	  $court=$row['court'];
	  $case_stage=$row['case_stage'];
	  
	$sql1="SELECT name FROM `employees` where id= '{$client_no}'";
	$result1 = mysqli_query($con,$sql1);
	$row1 = mysqli_fetch_assoc($result1);
	$sql_loc="SELECT `id`, `location` FROM `locations` WHERE  id='{$loc}'";
	$result_loc = mysqli_query($con,$sql_loc);
	$row_loc = mysqli_fetch_assoc($result_loc);
	$sql_cou_cat= "SELECT `id`, `category_name` FROM `case_category` WHERE  id= '{$cou_cat}'";
	$result_cou_cat = mysqli_query($con,$sql_cou_cat);
	$row_cou_cat = mysqli_fetch_assoc($result_cou_cat);
	$sql_cou="SELECT `id`, `name`  FROM `court` WHERE id='{$court}'";
	$result_cou = mysqli_query($con,$sql_cou);
	$row_cou = mysqli_fetch_assoc($result_cou);
	$sql_cas_st="SELECT `id`, `name` FROM `case_stages` WHERE id='{$case_stage}'";
	$result_cas_st = mysqli_query($con,$sql_cas_st);
	$row_cas_st = mysqli_fetch_assoc($result_cas_st);
	$sql_case_categ="SELECT `case_id`, `case_category_id` FROM `cases_case_category` WHERE  case_id='{$id}'";
	$req_case_categ=mysqli_query($con,$sql_case_categ);
	$case_cate='';
	while($row_case_categ = mysqli_fetch_assoc($req_case_categ))
	{
		$emp_name = $row_case_categ['case_category_id'];
		$sql_case_categ_name="SELECT `id`, `category_name` FROM `case_category` WHERE id='{$emp_name}'";
		$req_case_categ_name=mysqli_query($con,$sql_case_categ_name);
		$row_case_categ_name = mysqli_fetch_assoc($req_case_categ_name);
		$emp_name1=ucfirst($row_case_categ_name['category_name']);
		$case_cate = rtrim(ltrim($case_cate.",". $emp_name1,","));
	}
	$act="";
	$sql_act="SELECT  `case_id`, `act_id` FROM `cases_act` WHERE case_id='{$id}'";
	$req_act=mysqli_query($con,$sql_act);
	while($row_act = mysqli_fetch_assoc($req_act))
	{
		$act_id = $row_act['act_id'];
		$sql_act_name="SELECT `id`, `name` FROM `act` WHERE id='{$act_id}'";
		$req_act_name=mysqli_query($con,$sql_act_name);
		$row_act_name = mysqli_fetch_assoc($req_act_name);
		$act_id_name = ucfirst($row_act_name['name']);
		$act = rtrim(ltrim($act.",". $act_id_name,","));
		
	}
	
	//echo $sql_cas_st." ".$sql_cou;
   $todolist[$cr]['id']      = $row['id'];
	$todolist[$cr]['case_title'] = $row['case_title'];
    $todolist[$cr]['case_no']   = $row['case_no'];
    $todolist[$cr]['client_name']   = $row['client_name'];
    $todolist[$cr]['location']   = $row['location'];
    $todolist[$cr]['court_category']   = $row['court_category'];
    $todolist[$cr]['court']   = $row['court'];
    $todolist[$cr]['case_stage']   = $row['case_stage'];
    $todolist[$cr]['description']   = $row['description'];
    $todolist[$cr]['filling_date']   = $row['filling_date'];
    $todolist[$cr]['hearing_date']   = $row['hearing_date'];
    $todolist[$cr]['apposite_lawyer']   = ucfirst($row['apposite_lawyer']);
    $todolist[$cr]['total_fees']   = $row['total_fees'];
    $todolist[$cr]['case_cate']   = $case_cate;
    $todolist[$cr]['act']   = $act;
	
	
    
    $cr++;
  }
    
  echo json_encode(['data'=>$todolist]);
}
else
{
  http_response_code(404);
}
