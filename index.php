<?php //echo ini_get('error_log');die; ?>

<!DOCTYPE html>
<html>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
		  // $("button").click(function()
		  // });
		  //$( "#name" ).keypress(function( event ) {
		  $('#name').on('input', function() {
		    $.ajax({url: "digit_sum_of_name.php?name="+$('#name').val(), success: function(result){
		      
		      var obj = JSON.parse(result);	
                tableBody = $("#sum");
                tableBody2 = $("#digit");
                tableBody.replaceWith("<td style=\"padding-left: 10px\" id=\"sum\">" + obj.sum + "<br><br></td>");
                tableBody2.replaceWith("<td style=\"padding-left: 10px\" id=\"digit\">" + obj.digit_sum + "<br><br></td>");



		    }});
		  });
		  $('#phone').on('input', function() {
		    $.ajax({url: "digit_sum_of_name.php?name="+$('#phone').val(), success: function(result){
		      
		      var obj = JSON.parse(result);	
		      // sum = obj.sum;
		      // digit_sum = obj.digit_sum;

		      // markup = sum + " Digit Sum: "+ digit_sum +"<br><br>";
                tableBody2 = $("#digit_phone");
                tableBody2.replaceWith("<td style=\"padding-left: 10px\" id=\"digit_phone\">" + obj.digit_sum + "<br><br></td>");



		    }});
		  });
		});
		
	</script>
	<body>

	<h1>Numerology</h1>
	<p>Please enter the user details</p>


	<form action="show_details.php">

		<table>
			<tr>
		    	<td>
		    		<label for="name">Name:</label>		<br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="text" id="name" name="name">	<br><br>
				</td>
			</tr>
				<td>
		    		<label for="sum">Sum of Name:</label>		<br><br>
				</td>
				<td style="padding-left: 10px" id="sum">
		    			<br><br>
				</td>

			<tr>
			</tr>
				<td>
		    		<label for="digit">Digit Sum of Name:</label>		<br><br>
				</td>
				<td style="padding-left: 10px" id="digit">
		    			<br><br>
				</td>

			<tr>	
		    	<td>
		    		<label for="dob">Date of Birth:</label><br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="date" id="dob" name="dob"><br><br>
				</td>
			</tr>
			<tr>
		    	<td>
		    		<label for="gender">Gender:</label><br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="radio" id="male" name="gender" value="male" checked="checked"">
					<label for="male">Male</label><br>
					<input type="radio" id="female" name="gender" value="female">
					<label for="female">Female</label>
					<br><br>	
				</td>
			</tr>
			<tr>
		    	<td>
		    		<label for="phone">Phone:</label>		<br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="text" id="phone" name="phone">	<br><br>
				</td>
			</tr>
			</tr>
				<td>
		    		<label for="digit_phone">Digit Sum of Phone:</label>		<br><br>
				</td>
				<td style="padding-left: 10px" id="digit_phone">
		    			<br><br>
				</td>

			<tr>
			<tr>
		    	<td>
		    		<input type="submit" value="Submit">	
				</td>
			</tr>
		</table>	

	</form>

	</body>
</html>