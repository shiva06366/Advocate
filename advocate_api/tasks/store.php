<?php
require '../connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
 // print_r($request->data->court_category_id[0]);
// print_r($request[0]->data->court_category_id);
  // Validate.
  if(trim($request->data->name) === '' || trim($request->data->priority) === '' || trim($request->data->due_date) === ''|| trim($request->data->case_id) === '' || trim($request->data->progress) === '' || trim($request->data->description) === '' || trim($request->data->created_by) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $name = mysqli_real_escape_string($con, trim($request->data->name));
  $priority = mysqli_real_escape_string($con, trim($request->data->priority));
  $due_date = mysqli_real_escape_string($con, trim($request->data->due_date));
  $case_id = mysqli_real_escape_string($con, trim($request->data->case_id));
  $progress = mysqli_real_escape_string($con, trim($request->data->progress));
  $description = mysqli_real_escape_string($con, trim($request->data->description));
  $employee_id = $request->data->employee_id;
  $created_by = mysqli_real_escape_string($con, trim($request->data->created_by));
 
$count_employee_id = count( $request->data->employee_id);
  // Store.
  $sql = "INSERT INTO `tasks`(`id`, `name`, `priority`, `due_date`, `case_id`, `progress`, `description`, `created_by`)  values (NULL, '{$name}', '{$priority}', '{$due_date}', '{$case_id}',  '{$progress}', '{$description}', '{$created_by}')";
  if(mysqli_query($con,$sql))
  {
	  $last_id = $con->insert_id;
	  for($i=0;$i<$count_employee_id;$i++){
		  
			$sql1="INSERT INTO `tasks_assign`(`id`, `task_id`, `emp_id`) VALUES (NULL,'{$last_id}',  {$request->data->employee_id[$i]})";
			mysqli_query($con,$sql1);
		}
    http_response_code(201);
    $add = [
	  'name' => $name,
      'priority' => $priority,
      'due_date' => $due_date,
	  'case_id' => $case_id,
	  'progress'=>$progress,
	  'description'=>$description,
	  'created_by'=>$created_by,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode(['data'=>$add,'output'=>true]);
  }
  else
  {
    http_response_code(422);
  }
}