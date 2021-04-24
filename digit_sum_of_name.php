<?php

require_once(__DIR__ .'/numerology.php');


$name = $_GET['name'];
$dob = '2020-01-01';
$gender = 'male';


$numerology = new Numerology();
// $numerology->set_user_details($name, $dob, $gender);



$sum_name = $numerology->get_sum_of_name($name);
$digit_sum_name = $numerology->digit_sum_reduce($sum_name);

echo json_encode([
	'sum' => $sum_name,
	'digit_sum' => $digit_sum_name,

]);

exit;