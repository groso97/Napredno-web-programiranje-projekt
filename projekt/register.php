<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

	print '
	<h1>Registration</h1>
	<div>';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
			<label for="firstname">First Name</label>
			<input type="text" id="firstname" name="firstname" placeholder="Your name.." required>

			<label for="lastname">Last Name</label>
			<input type="text" id="lastname" name="lastname" placeholder="Your last name.." required>
				
			<label for="email">E-mail:</label>
			<input type="email" id="email" name="email" placeholder="Your e-mail.." required>
			
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" placeholder="Username.." required><br>

            <label for="city">City:</label>
			<input type="text" id="city" name="city" placeholder="City you live in.." required><br>

            <label for="address">Address:</label>
			<input type="text" id="address" name="address" placeholder="Your address.." required><br>

            <label for="birth_date">Date of birth:</label>
			<input type="date" id="birth_date" name="birth_date" placeholder="Your date of birth.." required><br>
			
									
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" placeholder="Password.." required>

			<label for="country">Country:</label>
			<select name="country" id="country">
				<option value="">Please select</option>';
				$query  = "SELECT * FROM countries";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['country_code'] . '">' . $row['country_name'] . '</option>';
				}
			print '
			</select>
			<input type="submit" value="Submit">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		$MySQL = mysqli_connect("localhost","root","","konekcija") or die('Error connecting to MySQL server.');
		$query  = "SELECT * FROM users";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if ($row['email'] == '' || $row['username'] == '') {
			$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO users (firstname, lastname, email, username, city, address, birth_date, password, country)";
			$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $_POST['city'] . "', '" . $_POST['address'] . "', '" . $_POST['birth_date'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "')";
			$result = @mysqli_query($MySQL, $query);
			
			echo '<p>' . ucfirst(strtolower($_POST['firstname'])) . ' ' .  ucfirst(strtolower($_POST['lastname'])) . ', thank you for registration!</p>
			<hr>';
		}
		else {
			echo '<p>User with this email or username already exist!</p>';
		}
	}
	print '
	</div>';
?>