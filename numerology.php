<?php

class Numerology {

	public $nameology = [
		'a' => 1,
		'b' => 2,
		'c' => 3,
		'd' => 4,
		'e' => 5,
		'f' => 8,
		'g' => 3,
		'h' => 5,
		'i' => 1,
		'j' => 1,
		'k' => 2,
		'l' => 3,
		'm' => 4,
		'n' => 5,
		'o' => 7,
		'p' => 8,
		'q' => 1,
		'r' => 2,
		's' => 3,
		't' => 4,
		'u' => 6,
		'v' => 6,
		'w' => 6,
		'x' => 5,
		'y' => 1,
		'z' => 7,
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

	public $period_table = [
		1 => [26,53],
		2 => [25,52],
		3 => [24,51],
		4 => [23,59],
		5 => [31,58],
		6 => [30,57],
		7 => [29,56],
		8 => [28,55],
		9 => [27,54],
	];

	public $font_color = [
		'driver' => 'blue',
		'conductor' => 'red',
		'kua' => '#00cc66',
		'name' => 'orange',
		'zodiac_number' => '#fc03e3',
	];

	public $user_details = [];

	public $loshu_grid = [];

	public $phone_loshu_grid = [];

	public $numeroscope = [];

	public $loshu_grid_arrangement = [
		[4, 9, 2],
		[3, 5, 7],
		[8, 1, 6],
	];

	public $dasha = [];

	public $details_display_array = [];

	public $karmic_numbers = [11,13,14,16,19,21,26];
	public $karmic_number_occurance = [];
	public $karmic_number_occurance_string = [];

	function set_initial_details($name, $dob, $gender) {
		$this->user_details['name'] = $name;
		$this->user_details['dob'] = $dob;
		$this->user_details['gender'] = $gender;
	}

	public function get_sum_of_name($name = '') {
		
		if(empty($name)) {
			$name = $this->user_details['name'];
		} 
		$name_array = str_split(strtolower($name));
		$sum_of_name = 0;
		
		foreach ($name_array as $key => $value) {
			// echo $value;
			
			if(!empty($this->nameology[$value])) {
				$sum_of_name += $this->nameology[$value];
				// echo $this->nameology[$value]." ";
			}
		}

		return $sum_of_name;
	}

	function get_user_detail($variable) {
		return $this->user_details[$variable];
	}

	public function digit_sum_reduce($number, $type = 'none') 
	{ 
	    $sum = 0; 

	    if(in_array($number, $this->karmic_numbers)) {
	    	$this->karmic_number_occurance[$type][] = $number;
	    }

	    while($number > 0 || $sum > 9) 
	    { 
	        if($number == 0) 
	        { 
	        	if(in_array($sum, $this->karmic_numbers)){
	        		$this->karmic_number_occurance[$type][] = $sum;
	        	}
	        	$number = $sum; 
	            $sum = 0; 
	        } 
	        $sum += $number % 10; 
	        $number /= 10; 
	    } 
	    return $sum; 
	}

	function digit_sum_no_reduce($number, $type = 'none') 
	{ 
	    $sum = 0; 

	    if(in_array($number, $this->karmic_numbers)) {
	    	$this->karmic_number_occurance[$type][] = $number;
	    }

	    if($number == 11 || $number == 22 || $number == 33)
    		return $number;

	    while($number > 0 || $sum > 9) 
	    { 
	        if($number == 0) 
	        { 

	        	if(in_array($sum, $this->karmic_numbers)){
	        		$this->karmic_number_occurance[$type][] = $sum;
	        	}

	        	if($sum == 11 || $sum == 22 || $sum == 33) {
	        		return $sum;
	        	}
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
		//var_dump($split_dob);
		$user_details['day'] = intval($split_dob[0]);
		$user_details['month'] = intval($split_dob[1]);
		$user_details['year'] = intval($split_dob[2]);
		return $user_details;
	}

	function set_date_variables() {
		$user_details = $this->split_date($this->user_details['dob']);
		//var_dump($user_details);
		$user_details['digit_sum_day'] = $this->digit_sum_no_reduce($user_details['day'], 'driver');
		$user_details['digit_sum_month'] = $this->digit_sum_no_reduce($user_details['month']);
		$user_details['digit_sum_year'] = $this->digit_sum_no_reduce($user_details['year']);
		$user_details['sum_dob'] = $user_details['digit_sum_day'] + $user_details['digit_sum_month'] + $user_details['digit_sum_year'];
		$user_details['digit_sum_dob'] = $this->digit_sum_reduce($user_details['sum_dob'], 'conductor');
		$user_details['universal_year'] = $this->digit_sum_reduce(date('Y', strtotime("now")));
		$user_details['personal_year'] = $this->digit_sum_reduce($user_details['digit_sum_day'] + $user_details['digit_sum_month'] + $user_details['universal_year'], 'personal_year');
		$user_details['personal_month'] = $this->digit_sum_reduce($user_details['personal_year'] + $this->digit_sum_reduce(date('m', strtotime("now"))), 'personal_month');
		$user_details['age'] = date_diff(date_create($this->user_details['dob']), date_create('today'))->y;

		$this->user_details = array_merge($this->user_details, $user_details);
	}

	function fill_loshu_grid() {
		$loshu_array = [];
		$dob_array = str_split($this->user_details['dob']);
		foreach ($dob_array as $key => $value) {
			if(!empty($loshu_array[$value])) {
				$loshu_array[$value]++;
			}
			else {
				$loshu_array[$value] = 1;
			}
			
		}
		for($i=0;$i<3;$i++) {
			for ($j=0;$j<3;$j++) {
				if(!empty($loshu_array[$this->loshu_grid_arrangement[$i][$j]])) {
					$this->loshu_grid[$i][$j] = $loshu_array[$this->loshu_grid_arrangement[$i][$j]];
				}
				else {
					$this->loshu_grid[$i][$j] = 0;
				}
				
			}
		}
		// print_r($this->loshu_grid);
	}

	function fill_phone_loshu_grid($phone) {
		$phone_loshu_array = [];
		$phone_array = str_split($phone);
		foreach ($phone_array as $key => $value) {
			if(!empty($loshu_array[$value])) {
				$loshu_array[$value]++;
			}
			else {
				$loshu_array[$value] = 1;
			}
			
		}
		for($i=0;$i<3;$i++) {
			for ($j=0;$j<3;$j++) {
				if(!empty($loshu_array[$this->loshu_grid_arrangement[$i][$j]])) {
					$this->phone_loshu_grid[$i][$j] = $loshu_array[$this->loshu_grid_arrangement[$i][$j]];
				}
				else {
					$this->phone_loshu_grid[$i][$j] = 0;
				}
				
			}
		}
		// print_r($this->loshu_grid);
	}

	function set_sunsign() {
		$user_details = $this->split_date($this->user_details['dob']);
		$day = $user_details['day'];
		$month = $user_details['month'];
		$year = $user_details['year'];
		if ( ( $month == 3 && $day >= 21 ) || ( $month == 4 && $day <= 20 ) ) { $zodiac = "Aries F "; $zodiac_number = 9; }
		elseif ( ( $month == 4 && $day >= 21 ) || ( $month == 5 && $day <= 21 ) ) { $zodiac = "Taurus E "; $zodiac_number = 6;}
		elseif ( ( $month == 5 && $day >= 22 ) || ( $month == 6 && $day <= 21 ) ) { $zodiac = "Gemini A "; $zodiac_number = 5;}
		elseif ( ( $month == 6 && $day >= 22 ) || ( $month == 7 && $day <= 23 ) ) { $zodiac = "Cancer W "; $zodiac_number = 2;}
		elseif ( ( $month == 7 && $day >= 24 ) || ( $month == 8 && $day <= 23 ) ) { $zodiac = "Leo F "; $zodiac_number = 1;}
		elseif ( ( $month == 8 && $day >= 24 ) || ( $month == 9 && $day <= 23 ) ) { $zodiac = "Virgo E "; $zodiac_number = 5;}
		elseif ( ( $month == 9 && $day >= 24 ) || ( $month == 10 && $day <= 23 ) ) { $zodiac = "Libra A "; $zodiac_number = 6;}
		elseif ( ( $month == 10 && $day >= 24 ) || ( $month == 11 && $day <= 22 ) ) { $zodiac = "Scorpio W "; $zodiac_number = 9;}
		elseif ( ( $month == 11 && $day >= 23 ) || ( $month == 12 && $day <= 21 ) ) { $zodiac = "Sagittarius F "; $zodiac_number = 3;}
		elseif ( ( $month == 12 && $day >= 22 ) || ( $month == 1 && $day <= 20 ) ) { $zodiac = "Capricorn E "; $zodiac_number = 8; }
		elseif ( ( $month == 1 && $day >= 21 ) || ( $month == 2 && $day <= 19 ) ) { $zodiac = "Aquarius A "; $zodiac_number = 4;}
		elseif ( ( $month == 2 && $day >= 20 ) || ( $month == 3 && $day <= 20 ) ) { $zodiac = "Pisces W "; $zodiac_number = 7;}
		$this->user_details['zodiac'] = $zodiac."<b><span style=\"color:".$this->font_color['zodiac_number']."\">".$zodiac_number."</span></b> ";
		$this->user_details['zodiac_number'] = $zodiac_number;
	}


	function print_loshu_grid() {
		echo "<table align=\"left\" border=\"1\" cellpadding=\"3\" cellspacing=\"0\">";


		for ($i = 0; $i < 3; $i++) {
			echo "<tr>";
			
			for ($j = 0; $j < 3; $j++) {
				echo "<td>&nbsp";
				for ($k = 0; $k < $this->loshu_grid[$i][$j]; $k++) {
					echo $this->loshu_grid_arrangement[$i][$j]." ";
				}
				if($this->user_details['driver'] == $this->loshu_grid_arrangement[$i][$j]) {
					echo "<b><span style=\"color:".$this->font_color['driver']."\">".$this->loshu_grid_arrangement[$i][$j]."</span></b> ";
				}
				if($this->user_details['conductor'] == $this->loshu_grid_arrangement[$i][$j]) {
					echo "<b><span style=\"color:".$this->font_color['conductor']."\">".$this->loshu_grid_arrangement[$i][$j]."</span></b> ";
				}
				if($this->user_details['kua'] == $this->loshu_grid_arrangement[$i][$j]) {
					echo "<b><span style=\"color:".$this->font_color['kua']."\">".$this->loshu_grid_arrangement[$i][$j]."</span></b> ";
				}
				if($this->user_details['digit_sum_of_name'] == $this->loshu_grid_arrangement[$i][$j]) {
					echo "<b><span style=\"color:".$this->font_color['name']."\">".$this->loshu_grid_arrangement[$i][$j]."</span></b> ";
				}
				if($this->user_details['zodiac_number'] == $this->loshu_grid_arrangement[$i][$j]) {
					echo "<b><span style=\"color:".$this->font_color['zodiac_number']."\">".$this->loshu_grid_arrangement[$i][$j]."</span></b> ";
				}
				echo "&nbsp</td>";
			}
			echo "</tr>";
			}
		echo "</table>";
	}

	function print_phone_loshu_grid() {
		echo "<table align=\"left\" border=\"1\" cellpadding=\"3\" cellspacing=\"0\">";


		for ($i = 0; $i < 3; $i++) {
			echo "<tr>";
			
			for ($j = 0; $j < 3; $j++) {
				echo "<td>&nbsp";
				for ($k = 0; $k < $this->phone_loshu_grid[$i][$j]; $k++) {
					echo $this->loshu_grid_arrangement[$i][$j]." ";
				}
				echo "&nbsp</td>";
			}
			echo "</tr>";
			}
		echo "</table>";
	}

	function get_kua() {
		// $yy = $this->user_details['year']%100;
		// $sum_yy = $this->digit_sum_reduce($yy);
		// $kua = 0;
		// if($this->user_details['gender'] == 'male') {
		// 	$kua = $this->digit_sum_reduce(10 - $sum_yy);
		// }
		// else {
		// 	$kua = $this->digit_sum_reduce(5 + $sum_yy);
		// }

		$yyyy = $this->user_details['year'];
		$sum_yyyy = $this->digit_sum_reduce($yyyy);
		$kua = 0;
		if($this->user_details['gender'] == 'male') {
			$kua = $this->digit_sum_reduce(11 - $sum_yyyy);
		}
		else {
			$kua = $this->digit_sum_reduce(4 + $sum_yyyy);
		}


		return $kua;
	}

	function set_dckn() {
		// print_r($this->user_details);
		$this->user_details['driver'] = $this->digit_sum_reduce($this->user_details['digit_sum_day']); // D
		$this->user_details['conductor'] = $this->get_user_detail('digit_sum_dob'); // C
		$this->user_details['kua'] = $this->get_kua(); //K
		$this->user_details['sum_of_name'] = $this->get_sum_of_name();
		$this->user_details['digit_sum_of_name'] = $this->digit_sum_reduce($this->user_details['sum_of_name']); //N
	}

	function set_phone_sum($phone) {
		$this->user_details['sum_of_phone'] = $this->get_sum_of_name($phone);
		$this->user_details['digit_sum_of_phone'] = $this->digit_sum_reduce($this->user_details['sum_of_phone']);
	}

	function create_pinnacle_chart() {
		$user_details = $this->split_date($this->user_details['dob']);
		$day = $this->digit_sum_reduce($user_details['day']);
		$month = $this->digit_sum_reduce($user_details['month']);
		$year = $this->digit_sum_reduce($user_details['year']);

		$p1 = $this->digit_sum_reduce($month + $day, 'P1');
		$p2 = $this->digit_sum_reduce($day + $year, 'P2');
		$p3 = $this->digit_sum_reduce($p1 + $p2, 'P3');
		$p4 = $this->digit_sum_reduce($month + $year, 'P4');

		$c1 = $this->digit_sum_no_reduce(abs($month - $day));
		$c2 = $this->digit_sum_no_reduce(abs($day - $year));
		$c3 = $this->digit_sum_no_reduce(abs($c1 - $c2));
		$c4 = $this->digit_sum_no_reduce(abs($month - $year));

		$age1 = 36 - $this->user_details['conductor'];
		$age2 = 36 - $this->user_details['conductor'] + 9;
		$age3 = 36 - $this->user_details['conductor'] + 18;
		$age4 = 36 - $this->user_details['conductor'] + 27;

		$yyyy = date('Y', strtotime($this->user_details['dob']));
		$year1 = $yyyy + $age1;
		$year2 = $yyyy + $age2;
		$year3 = $yyyy + $age3;
		$year4 = $yyyy + $age4;

		$this->create_karmic_number_occurance_string();

		$this->user_details['pinnacle_chart'] = [
			[
				'P1 (M+D)' => $p1.$this->karmic_number_occurance_string['P1'],
				'Age 1' => $age1,
				'Year 1' => $year1,
				'C1 (M-D)' => $c1,
				],
			[
				'P2 (D+Y)' => $p2.$this->karmic_number_occurance_string['P2'],
				'Age 2' => $age2,
				'Year 2' => $year2,
				'C2 (D-Y)' => $c2,
				],
			[
				'P3 (P1+P2)' => $p3.$this->karmic_number_occurance_string['P3'],
				'Age 3' => $age3,
				'Year 3' => $year3,
				'C3 (C1-C2)' => $c3,
				],
			[
				'P4 (M+Y)' => $p4.$this->karmic_number_occurance_string['P4'],
				'Age 4' => $age4,
				'Year 4' => $year4,
				'C4 (M-Y)' => $c4,
				],
			
		];

	}

	function display_pinnacle_chart() {
		echo "<table align=\"left\" border=\"1\" cellpadding=\"3\" cellspacing=\"0\">";


		foreach ($this->user_details['pinnacle_chart'] as $key1 => $value1) {

			echo "<tr>";
			
			foreach ($value1 as $key2 => $value2) {
				echo "<td>&nbsp";
				echo $key2."&nbsp</td><td>&nbsp".$value2;
				echo "&nbsp</td>";
			}
			echo "</tr>";
			}
		echo "</table>";
	}

	function set_user_details($name, $dob, $gender, $phone) {
		$this->set_initial_details($name, $dob, $gender);
		$this->set_date_variables();
		$this->set_dckn();
		$this->set_sunsign();
		$this->fill_loshu_grid();
		if(!empty($phone)){
			$this->fill_phone_loshu_grid($phone);
			$this->set_phone_sum($phone);
		}
		$this->create_karmic_number_occurance_string(); //for conductor and driver
		$this->create_detail_display_array();
		$this->create_pinnacle_chart();
		$this->create_karmic_number_occurance_string(); //for pinnacle
		$this->set_numeroscope();
	}

	function set_dasha() {
		$conductor = $this->user_details['conductor'];

		$i = 1;
		$this->dasha[0] = '-';
		$adder = $conductor;
		while($i <= 100) {
			$adder = $adder%10;
			for ($j=0; $j < $adder; $j++) { 
				$this->dasha[$i] = $adder;
				$i++;
			}
			$adder++;
		}

	}

	function get_dasha($age) {
		//return $age;
		return $this->dasha[$age];
	}

	function create_karmic_number_occurance_string() {
		if(!empty($this->karmic_number_occurance['driver'])) {
			$this->karmic_number_occurance_string['driver'] = "  [".implode(',', $this->karmic_number_occurance['driver'])."]";
		}
		else {
			$this->karmic_number_occurance_string['driver'] = "";
		}

		if(!empty($this->karmic_number_occurance['conductor'])) {
			// if(!empty($this->karmic_number_occurance['driver'])) {
			// 	$this->karmic_number_occurance['conductor'] = array_merge($this->karmic_number_occurance['conductor'],$this->karmic_number_occurance['driver']);
			// }
			$this->karmic_number_occurance_string['conductor'] = "  [".implode(',', $this->karmic_number_occurance['conductor'])."]";
		}
		else {
			$this->karmic_number_occurance_string['conductor'] = "";
		}

		//Pinnacle Variables

		if(!empty($this->karmic_number_occurance['P1'])) {
			$this->karmic_number_occurance_string['P1'] = "  [".implode(',', $this->karmic_number_occurance['P1'])."]";
		}
		else {
			$this->karmic_number_occurance_string['P1'] = "";
		}

		if(!empty($this->karmic_number_occurance['P2'])) {
			$this->karmic_number_occurance_string['P2'] = "  [".implode(',', $this->karmic_number_occurance['P2'])."]";
		}
		else {
			$this->karmic_number_occurance_string['P2'] = "";
		}

		if(!empty($this->karmic_number_occurance['P3'])) {
			$this->karmic_number_occurance_string['P3'] = "  [".implode(',', $this->karmic_number_occurance['P3'])."]";
		}
		else {
			$this->karmic_number_occurance_string['P3'] = "";
		}

		if(!empty($this->karmic_number_occurance['P4'])) {
			$this->karmic_number_occurance_string['P4'] = "  [".implode(',', $this->karmic_number_occurance['P4'])."]";
		}
		else {
			$this->karmic_number_occurance_string['P4'] = "";
		}
		
		//Personal Year
		if(!empty($this->karmic_number_occurance['personal_year'])) {
			$this->karmic_number_occurance_string['personal_year'] = "  [".implode(',', $this->karmic_number_occurance['personal_year'])."]";
		}
		else {
			$this->karmic_number_occurance_string['personal_year'] = "";
		}
		if(!empty($this->karmic_number_occurance['personal_month'])) {
			$this->karmic_number_occurance_string['personal_month'] = "  [".implode(',', $this->karmic_number_occurance['personal_month'])."]";
		}
		else {
			$this->karmic_number_occurance_string['personal_month'] = "";
		}
	}

	function set_numeroscope() {

		$yyyy = date('Y', strtotime($this->user_details['dob']));
		$this->set_dasha();

		$this->user_details['numeroscope'][] = [
			'Year' => 'Year',
			'Age' => 'Age',
			'Period' => 'Period',
			'Pinnacle' => 'Pinnacle',
			'UY' => 'UY',
			'PY' => 'PY',
			'Dasha' => 'Dasha',
		];
		for ($i = 0; $i <= 80; $i++) { 
			$this->user_details['numeroscope'][] = [
				'Year' => $yyyy + $i,
				'Age' => $i,
				'period' => $this->get_period_by_age($i),
				'Pinnacle' => $this->get_pinnacle_by_age($i),
				'UY' => $this->digit_sum_reduce($yyyy + $i),
				'PY' => $this->digit_sum_reduce($this->user_details['digit_sum_day'] + $this->user_details['digit_sum_month'] + $this->digit_sum_reduce($yyyy + $i)),
				'Dasha' => $this->get_dasha($i),
			];
			 // var_dump($this->numeroscope);die;
		}
	}

	function get_period_by_age($age) {
		$period_table = $this->period_table[$this->user_details['conductor']];
		
		if($age >= 0 && $age <= $period_table[0]) {
			return $this->digit_sum_reduce($this->user_details['digit_sum_month']);
		}
		else if($age > $period_table[0] && $age <= $period_table[1]) {
			return $this->digit_sum_reduce($this->user_details['digit_sum_day']);
		}
		else {
			return $this->digit_sum_reduce($this->user_details['digit_sum_year']);
		}
	}

	function get_pinnacle_by_age($age) {
		// var_dump($this->user_details['pinnacle_chart'][3]);die;

		if($age >= 0 && $age <= $this->user_details['pinnacle_chart'][0]['Age 1']) {
			return $this->user_details['pinnacle_chart'][0]['P1 (M+D)'];
		}
		else if($age > $this->user_details['pinnacle_chart'][0]['Age 1'] && $age <= $this->user_details['pinnacle_chart'][1]['Age 2']) {
			return $this->user_details['pinnacle_chart'][1]['P2 (D+Y)'];
		}
		else if($age > $this->user_details['pinnacle_chart'][1]['Age 2'] && $age <= $this->user_details['pinnacle_chart'][2]['Age 3']) {
			return $this->user_details['pinnacle_chart'][2]['P3 (P1+P2)'];
		}
		else if($age > $this->user_details['pinnacle_chart'][2]['Age 3'] && $age <= $this->user_details['pinnacle_chart'][3]['Age 4']) {
			return $this->user_details['pinnacle_chart'][3]['P4 (M+Y)'];
		}
		else {
			return '';
		}

	}

	function display_numeroscope() {
		echo "<table align=\"left\" border=\"1\" cellpadding=\"3\" cellspacing=\"0\">";


		foreach ($this->user_details['numeroscope'] as $key1 => $value1) {

			if($this->user_details['age'] == $value1['Age']) {
				echo "<tr style=\"color:".$this->font_color['conductor']."; font-weight:bold\"><b>";
			}
			else {
				echo "<tr>";
			}
			
			foreach ($value1 as $key2 => $value2) {
				echo "<td>&nbsp".$value2;
				echo "&nbsp</td>";
			}


			if($this->user_details['age'] == $value1['Age']) {
				echo "</b></tr>";
			}
			else {
				echo "</tr>";
			}

		}
		echo "</table>";



		// "<b><span style=\"color:".$this->font_color['conductor']."\">".$this->user_details['conductor'].$this->karmic_number_occurance_string['conductor']."</span></b> ",

	}

	function create_detail_display_array() {
		$this->details_display_array = [
			'Name' => $this->user_details['name'],
			'Date of Birth' => $this->user_details['dob'],
			'Age' => $this->user_details['age'],
			'Gender' => ucfirst($this->user_details['gender']),
			'DCKN' => $this->user_details['driver']." ".$this->user_details['conductor']." ".$this->user_details['kua']." ".$this->user_details['digit_sum_of_name'],
			'Driver' => "<b><span style=\"color:".$this->font_color['driver']."\">".$this->user_details['driver'].$this->karmic_number_occurance_string['driver']."</span></b> ",
			'Conductor' => "<b><span style=\"color:".$this->font_color['conductor']."\">".$this->user_details['conductor'].$this->karmic_number_occurance_string['conductor']."</span></b> ",
			'Kua' => "<b><span style=\"color:".$this->font_color['kua']."\">".$this->user_details['kua']."</span></b> ",
			'Digit Sum of Name' => "<b><span style=\"color:".$this->font_color['name']."\">".$this->user_details['digit_sum_of_name']."</span></b> ",
			'Sum of Name' => $this->user_details['sum_of_name'],
			'Universal Year' => $this->user_details['universal_year'],
			'Personal Year' => $this->user_details['personal_year'].$this->karmic_number_occurance_string['personal_year'],
			'Personal Month' => $this->user_details['personal_month'].$this->karmic_number_occurance_string['personal_month'],
			'Astrological Sign' => $this->user_details['zodiac'],
		];
		if(!empty($this->user_details['digit_sum_of_phone'])) {
			$this->details_display_array['Digit Sum of Phone'] = $this->user_details['digit_sum_of_phone'];
		}
	}

}