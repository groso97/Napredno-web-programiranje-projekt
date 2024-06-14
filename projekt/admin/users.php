<?php 
	if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
		$query  = "UPDATE users SET firstname='" . $_POST['firstname'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', username='" . $_POST['username'] . "', country='" . $_POST['country'] . "', role='" . $_POST['role'] . "', archive='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		@mysqli_close($MySQL);
		
		$_SESSION['message'] = '<p>You successfully changed user profile!</p>';
		
		header("Location: index.php?menu=8&action=1");
	}
	
	
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM users";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>You successfully deleted user profile!</p>';
		
		header("Location: index.php?menu=8&action=1");
	}
	
	
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>User profile</h2>
		<p><b>First name:</b> ' . $row['firstname'] . '</p>
		<p><b>Last name:</b> ' . $row['lastname'] . '</p>
		<p><b>Username:</b> ' . $row['username'] . '</p>';
		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE country_code='" . $row['country'] . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Country:</b> ' .$_row['country_name'] . '</p>
        <p><b>City:</b> ' . $row['city'] . '</p>
        <p><b>Address:</b> ' . $row['address'] . '</p>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';

        
	}
	
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		if ($_SESSION['user']['role'] == 1) {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;
		
		print '
		<h2>Edit user profile</h2>
		<form action=""  method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
			<label for="firstname">First Name</label>
			<input type="text" id="firstname" name="firstname" value="' . $row['firstname'] . '" placeholder="Your name.." required>

			<label for="lastname">Last Name</label>
			<input type="text" id="lastname" name="lastname" value="' . $row['lastname'] . '" placeholder="Your last name.." required>
				
			<label for="email">Your E-mail</label>
			<input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Your e-mail.." required>
			
			<label for="username">Username</label>
			<input type="text" id="username" name="username" value="' . $row['username'] . '" placeholder="Username.." required><br>
			
			<label for="country">Country</label>
			<select name="country" id="country">
				<option value="">Please select</option>';
				$_query  = "SELECT * FROM countries";
				$_result = @mysqli_query($MySQL, $_query);
				while($_row = @mysqli_fetch_array($_result)) {
					print '<option value="' . $_row['country_code'] . '"';
					if ($row['country'] == $_row['country_code']) { print ' selected'; }
					print '>' . $_row['country_name'] . '</option>';
				}
			print '
			</select>

            <label for="city">City</label>
			<input type="text" id="city" name="city" value="' . $row['city'] . '" placeholder="City.." required><br>

            <label for="address">Address</label>
			<input type="text" id="address" name="address" value="' . $row['address'] . '" placeholder="Address.." required><br>

			<input type="radio" name="role" value="1"'; if($row['role'] == 1) { echo ' checked="checked"'; $checked_archive = true; } echo ' /> Admin &nbsp;&nbsp;
            <input type="radio" name="role" value="3"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> User
            <input type="radio" name="role" value="2"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> Editor
			
			<br>
			
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="YES"'; if($row['archive'] == 'YES') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="NO"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO			
			<hr>	
			<input type="submit" value="Submit">
		</form>
		<p style="margin-bottom:60px;"><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
			}
			else {
				print 'Forbidden access!';
			}
	}

	else {
		if ($_SESSION['user']['role'] == 1) {
		print '
		<h2>List of users</h2>
		<div id="users">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>First name</th>
						<th>Last name</th>
						<th>E-mail</th>
						<th>Country</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM users";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="images/user.png" alt="user"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="images/edit.png" alt="edit"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="images/delete.png" alt="delete"></a></td>
						<td><strong>' . $row['firstname'] . '</strong></td>
						<td><strong>' . $row['lastname'] . '</strong></td>
						<td>' . $row['email'] . '</td>
						<td>';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE country_code='" . $row['country'] . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
						<td>';
							if ($row['archive'] == 'YES') { print '<img src="images/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'NO') { print '<img src="images/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
			}
			else {
				print 'Forbidden access!';
			}
	}
	
	@mysqli_close($MySQL);
?>