<?php //echo ini_get('error_log');die; ?>

<!DOCTYPE html>
<html>
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
				</td>
			</tr>
			<tr>
		    	<td>
		    		<input type="submit" value="Submit">	
				</td>
			</tr>
		</table>	

	</form>

	</body>
</html>