<?php

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


class Numerology {

	public $nameology = [
		'a' => 1,
		'b' => 2,
		'c' => 3,
		'd' => 4,
		'e' => 5,
		'f' => 6,
		'g' => 7,
		'h' => 8,
		'i' => 9,
		'j' => 1,
		'k' => 2,
		'l' => 3,
		'm' => 4,
		'n' => 5,
		'o' => 6,
		'p' => 7,
		'q' => 8,
		'r' => 9,
		's' => 1,
		't' => 2,
		'u' => 3,
		'v' => 4,
		'w' => 5,
		'x' => 6,
		'y' => 7,
		'z' => 8,
	];

	public $date_digit = [
		'0' => 0,
		'1' => 1,
		'2' => 2,
		'3' => 3,
		'4' => 4,
		'5' => 5,
		'6' => 6,
		'7' => 7,
		'8' => 8,
		'9' => 9,
	];

	public $vowels = ['a','e','i','o','u','y'];

	public $compatibility_chart = [
		0 => [1,2,2,3,1,3,1,4,2],
		1 => [2,1,2,1,3,2,3,1,2],
		2 => [2,2,1,3,2,1,3,3,1],
		3 => [3,1,3,1,3,2,2,1,3],
		4 => [1,3,2,3,1,3,1,4,2],
		5 => [3,2,1,2,3,1,3,2,1],
		6 => [1,3,3,2,1,3,1,3,3],
		7 => [4,1,3,1,4,2,3,1,3],
		8 => [2,2,1,3,2,1,3,3,1],
	];

	public $compatibility_stars = [
		[3,2,1,4,4,2,4,3,1],
		[2,3,3,4,3,4,3,1,3],
		[1,3,4,3,2,4,2,4,4],
		[4,4,3,3,1,3,4,4,1],
		[4,3,2,1,3,2,4,1,3],
		[2,4,4,3,2,4,2,2,4],
		[4,3,2,4,4,2,3,1,3],
		[3,1,4,4,1,2,1,3,2],
		[1,3,4,1,3,4,3,2,4],
	];

	public $compatibility_chart_label = [
		1 => '&#10003; &#10003;',
		2 => '&#10003;',
		3 => '&#4030;',
		4 => '&#9644;',
	];


	public $user_details = [];

	public $details_display_array = [];

	function set_initial_details($name1, $dob1, $name2, $dob2) {
		$this->user_details[0]['name'] = $name1;
		$this->user_details[0]['dob'] = $dob1;
		$this->user_details[1]['name'] = $name2;
		$this->user_details[1]['dob'] = $dob2;
	}

	function get_sum_of_name($i, $type = 'none') {
		
		$name_array = str_split(strtolower($this->user_details[$i]['name']));
		$sum_of_name = 0;
		
		foreach ($name_array as $key => $value) {
			// echo $value;
			
			if($type == 'vowel') {
				if(!empty($this->nameology[$value]) && in_array($value, $this->vowels)) {
					$sum_of_name += $this->nameology[$value];
					// echo $this->nameology[$value]." ";
				}
			}
			else if($type == 'consonants') {
				if(!empty($this->nameology[$value]) && !in_array($value, $this->vowels)) {
					$sum_of_name += $this->nameology[$value];
					// echo $this->nameology[$value]." ";
				}
			}
			else {
				if(!empty($this->nameology[$value])) {
					$sum_of_name += $this->nameology[$value];
					// echo $this->nameology[$value]." ";
				}
			}

			
		}

		return $sum_of_name;
	}

	function get_user_detail($variable) {
		return $this->user_details[$variable];
	}

	function digit_sum_reduce($number) 
	{ 
	    $sum = 0; 

	    while($number > 0 || $sum > 9) 
	    { 
	        if($number == 0) 
	        { 
	        	$number = $sum; 
	            $sum = 0; 
	        } 
	        $sum += $number % 10; 
	        $number /= 10; 
	    } 
	    return $sum; 
	}

	function split_date($dob) {
		$split_dob = explode('-', $dob);
		// print_r($split_dob); 
		$user_details['day'] = intval($split_dob[0]);
		$user_details['month'] = intval($split_dob[1]);
		$user_details['year'] = intval($split_dob[2]);
		return $user_details;
	}

	function set_date_variables() {
		

		for ($i=0; $i <= 1 ; $i++) { 
			$user_details = $this->split_date($this->user_details[$i]['dob']);

			$user_details['digit_sum_day'] = $this->digit_sum_reduce($user_details['day']);
			$user_details['digit_sum_month'] = $this->digit_sum_reduce($user_details['month']);
			$user_details['digit_sum_year'] = $this->digit_sum_reduce($user_details['year']);
			$user_details['sum_dob'] = $user_details['digit_sum_day'] + $user_details['digit_sum_month'] + $user_details['digit_sum_year'];
			$user_details['digit_sum_dob'] = $this->digit_sum_reduce($user_details['sum_dob']);
			$user_details['sum_ddmm'] = $user_details['digit_sum_day'] + $user_details['digit_sum_month'] + $user_details['digit_sum_year'];
			$user_details['digit_ddmm'] = $this->digit_sum_reduce($user_details['sum_ddmm']);
			$user_details['age'] = date_diff(date_create($this->user_details[$i]['dob']), date_create('today'))->y;

			$this->user_details[$i] = array_merge($this->user_details[$i], $user_details);

		}
		

	}

	function check_compatibility($type) {
		// var_dump($type, $this->compatibility_chart[$this->user_details[0][$type] - 1][$this->user_details[1][$type] - 1],$this->compatibility_chart_label[$this->compatibility_chart[$this->user_details[0][$type] - 1][$this->user_details[1][$type]] - 1],$this->user_details[0][$type] - 1,$this->user_details[1][$type] - 1);
		return $this->compatibility_chart_label[$this->compatibility_chart[$this->user_details[0][$type] - 1][$this->user_details[1][$type] - 1]];
	}



	function set_snpbla() {
		
		for ($i=0; $i <= 1 ; $i++) { 
			$this->user_details[$i]['Soul'] = $this->digit_sum_reduce($this->get_sum_of_name($i, 'vowel')); //S
			$this->user_details[$i]['Personality'] = $this->digit_sum_reduce($this->get_sum_of_name($i, 'consonant')); // P
			$this->user_details[$i]['NameSum'] = $this->digit_sum_reduce($this->get_sum_of_name($i, 'none')); //N
			$this->user_details[$i]['BirthDate'] = $this->user_details[$i]['digit_sum_day']; //B
			$this->user_details[$i]['Conductor'] = $this->user_details[$i]['digit_sum_dob']; //L
			$this->user_details[$i]['Attitude'] = $this->user_details[$i]['digit_ddmm']; //A
		}


		$this->user_details[2]['Soul'] = $this->check_compatibility('Soul');
		$this->user_details[2]['Personality'] = $this->check_compatibility('Personality');
		$this->user_details[2]['NameSum'] = $this->check_compatibility('NameSum');
		$this->user_details[2]['BirthDate'] = $this->check_compatibility('BirthDate');
		$this->user_details[2]['Conductor'] = $this->check_compatibility('Conductor');
		$this->user_details[2]['Attitude'] = $this->check_compatibility('Attitude');

		// var_dump($this->compatibility_chart_label);
		
	}



	function set_user_details($name1, $dob1, $name2, $dob2) {
		$this->set_initial_details($name1, $dob1, $name2, $dob2);
		$this->set_date_variables();
		$this->set_snpbla();
		$this->create_detail_display_array();

	}

	function get_compatibility_stars() {
		return $this->compatibility_stars[$this->user_details[0]['Conductor'] - 1][$this->user_details[1]['Conductor'] - 1];
	}



	function create_detail_display_array() {
			
		$this->user_details[2]['name'] = 'Compatibility';
			
		for ($i=0; $i <= 2 ; $i++) { 
			$this->details_display_array[$i] = [
				'Name' => $this->user_details[$i]['name'],
				'Soul' => $this->user_details[$i]['Soul'],
				'Personality' => $this->user_details[$i]['Personality'],
				'NameSum' => $this->user_details[$i]['NameSum'],
				'BirthDate' => $this->user_details[$i]['BirthDate'],
				'Conductor' => $this->user_details[$i]['Conductor'],
				'Attitude' => $this->user_details[$i]['Attitude'],
			];
		}
	}

}


$name1 = 'Ravi Prakash Sondhi';
$dob1 = '01-12-1962';

$name2 = 'Renu Sondhi';
$dob2 = '28-04-1965';


if(!empty($_GET['name1'])) {
	$name1 = $_GET['name1'];
}

if(!empty($_GET['name2'])) {
	$name2 = $_GET['name2'];
}

if(!empty($_GET['dob1'])) {
	
	$dob1 = $_GET['dob1'];
	$original_date = $dob1;
	$timestamp = strtotime($original_date);
	$new_date = date("d-m-Y", $timestamp);
	$dob1 = $new_date;
}

if(!empty($_GET['dob2'])) {
	
	$dob2 = $_GET['dob2'];
	$original_date = $dob2;
	$timestamp = strtotime($original_date);
	$new_date = date("d-m-Y", $timestamp);
	$dob2 = $new_date;
}


$numerology = new Numerology();
$numerology->set_user_details($name1, $dob1, $name2, $dob2);
// print_r($numerology->user_details);
// $numerology->print_loshu_grid();




?>

<!DOCTYPE html>
<html>
	<body>

		<h1>Numerology</h1>
		<p>Please find the details below</p>

		 <table> <!--align="left" border="1" cellpadding="3" cellspacing="0"> -->

			<?php for($i = 0; $i <= 1; $i++): ?>
				<tr>
				     <td>Person <?php echo $i + 1; ?> Details</td>
				     <td></td>
				</tr>
				<tr>
				     <td>Name</td>
				     <td><?php echo $numerology->user_details[$i]['name']; ?></td>
				</tr>
				<tr>
				     <td>Date of Birth</td>
				     <td><?php echo $numerology->user_details[$i]['dob']; ?></td>
				</tr>
				<tr>
				     <td>Age</td>
				     <td><?php echo $numerology->user_details[$i]['age']; ?></td>
				</tr>
				<tr>
				     <td><br></td>
				     <td></td>
				</tr>
			<?php endfor; ?>


		</table>

		<p>Compatibility Stars</p>
		<?php 
			for($i=0; $i < $numerology->get_compatibility_stars(); $i++)
				echo "&#9733;";
		?>

		<br><br>
		<p>Compatibility Chart</p>
		<table align="left" border="1" cellpadding="3" cellspacing="0">
			<?php foreach ($numerology->details_display_array[0] as $key1 => $value1): ?>
			
				
				<tr>	
					<td><?php echo($key1); ?></td>
					<td><?php echo($numerology->details_display_array[0][$key1]); ?></td>
					<td><?php echo($numerology->details_display_array[1][$key1]); ?></td>
					<td><?php echo($numerology->details_display_array[2][$key1]); ?></td>
				</tr>	
					
			
			<?php endforeach; ?>
		</table>

		<br><br><br><br><br><br><br><br>




<?php //var_dump($numerology->user_details); ?>

	</body>
</html>
