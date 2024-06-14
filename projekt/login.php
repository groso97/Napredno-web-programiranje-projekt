<?php

$MySQL = mysqli_connect("localhost","root","","konekcija") or die('Failed to connect to MySQL server.');
	print '
	<main>
	<h1>Login</h1>
		<div>';
		if ($_POST['_action_'] == FALSE) {
			
			print '
			<form action="" method="POST">
				<input type="hidden" id="_action_" name="_action_" value="TRUE">

				<label for="username">Username</label>
				<input type="text" name="username" value="" placeholder="Your username..." required>
										
				<label for="password">Password</label>
				<input type="password" name="password" value="" placeholder="Your password..." required>
										
				<input type="submit" value="Submit">
			</form>';
		}
		else if ($_POST['_action_'] == TRUE) {
			$query  = "SELECT * FROM users WHERE username = '" .  $_POST['username'] . "'";
			$result = @mysqli_query($MySQL, $query);
			$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
			
				if (password_verify($_POST['password'], $row['password'])) {
					if($row['archive'] == 'NO') {
					$_SESSION['user']['valid'] = 'true';
					$_SESSION['user']['id'] = $row['id'];
					$_SESSION['user']['role'] = $row['role'];
					$_SESSION['user']['firstname'] = $row['firstname'];
					$_SESSION['user']['lastname'] = $row['lastname'];
					$_SESSION['message'] = '<p>Welcome, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '!</p>';
					header("location: index.php?menu=8");
					}
					else {
                        $_SESSION['message'] = 'You must be approved by the administrator to be able to log in!';
                        header("location: index.php?menu=7");
                    }
				}

				else {
					unset($_SESSION['user']);
					$_SESSION['message'] = '<p>You entered wrong username or password.</p>';
					header("Location: index.php?menu=7");
				}
		}
		print '
		</div>
		</main>';
?>