<!DOCTYPE html>
<html>
	<body>

	<h1>Numerology</h1>
	<p>Please enter the user details of both the users</p>


	<form action="check_compatibility.php">

		<table>
			<tr>
		    	<td>
		    		<label for="name">Name of Person 1:</label>		<br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="text" id="name" name="name1">	<br><br>
				</td>
			</tr>
			<tr>
		    	<td>
		    		<label for="dob">Date of Birth of Person 1:</label><br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="date" id="dob" name="dob1"><br><br>
				</td>
			</tr>
			<!-- <tr>
		    	<td>
		    		<label for="gender">Gender:</label><br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="radio" id="male" name="gender1" value="male" checked="checked"">
					<label for="male">Male</label><br>
					<input type="radio" id="female" name="gender1" value="female">
					<label for="female">Female</label>	
				</td>
			</tr> -->
			<tr>
		    	<td>
		    		<label for="name">Name of Person 2:</label>		<br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="text" id="name" name="name2">	<br><br>
				</td>
			</tr>
			<tr>
		    	<td>
		    		<label for="dob">Date of Birth of Person 2:</label><br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="date" id="dob" name="dob2"><br><br>
				</td>
			</tr>
			<!-- <tr>
		    	<td>
		    		<label for="gender">Gender:</label><br><br>
				</td>
				<td style="padding-left: 10px">
		    		<input type="radio" id="male" name="gender2" value="male" checked="checked"">
					<label for="male">Male</label><br>
					<input type="radio" id="female" name="gender2" value="female">
					<label for="female">Female</label>	
				</td>
			</tr> -->
			<tr>
		    	<td>
		    		<input type="submit" value="Submit">	
				</td>
			</tr>
		</table>	

	</form>

	</body>
</html>