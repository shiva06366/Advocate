<?php
require 'connect.php';
$dataPoints = array ('results' => array (
    0 => 
    array (
      'label' => 'Total Case Amount',
      'y' => '125800',
    ),
    1 => 
    array (
      'label' => 'Invoice Raise',
      'y' => '45800',
    ),
    2 => 
    array (
      'label' => 'Receipt Raise',
      'y' => '25800',
    ),
    3 => 
    array (
      'label' => 'Total Pending',
      'y' => '100000',
    ),
    
  ),
);
echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
?>