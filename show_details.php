<?php

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

require_once(__DIR__ .'/numerology.php');



$name = 'Vijay Sahil Sondhi';
$dob = '03-12-1992';
$gender = 'male';


if(!empty($_GET['name'])) {
	$name = $_GET['name'];
}

if(!empty($_GET['dob'])) {
	
	$dob = $_GET['dob'];
	$original_date = $dob;
	$timestamp = strtotime($original_date);
	$new_date = date("d-m-Y", $timestamp);
	$dob = $new_date;
}

if(!empty($_GET['gender'])) {
	$gender = $_GET['gender'];
}

if(!empty($_GET['phone'])) {
	$phone = $_GET['phone'];
}
else {
	$phone = NULL;
}

$numerology = new Numerology();
$numerology->set_user_details($name, $dob, $gender, $phone);
// print_r($numerology->user_details);
// $numerology->print_loshu_grid();




?>

<!DOCTYPE html>
<html>
	<body>

		<h1>Numerology</h1>
		<p>Please find the details below</p>

		<table><!--  align="left" border="1" cellpadding="3" cellspacing="0" -->

			<?php foreach ($numerology->details_display_array as $key => $value): ?>
			<tr>
			     <td><?php echo $key ?></td>
			     <td><?php echo $value ?></td>
			</tr>
			<?php endforeach; ?>
		</table>

		<br><br>
		<p>Loshu Grid</p>
		<?php $numerology->print_loshu_grid(); ?>

		<br><br><br><br><br>

		<?php if(!empty($phone)) {
			echo "<p>Phone Loshu Grid</p>";
			$numerology->print_phone_loshu_grid();

			echo "<br><br><br><br><br><br><br><br>";
		}
		else {
			echo "<br><br><br>";	
		}
		?>

		<div>Pinnacle Chart</div>
		<?php $numerology->display_pinnacle_chart(); ?>

		<br><br><br><br><br><br><br><br>

		<div>Numeroscope</div>
		<?php $numerology->display_numeroscope(); ?>


<?php //var_dump($numerology->karmic_number_occurance); ?>

	</body>
</html>
