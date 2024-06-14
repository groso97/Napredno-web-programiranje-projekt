<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if (!isset($action)) { $action = 1; }
		print '

		<div id="admin">
			<ul>
				<li><a href="index.php?menu=8&amp;action=1">Users</a></li>
				<li><a href="index.php?menu=8&amp;action=2">News</a></li>
			</ul>
			<h1 style="text-align:center">Administration</h1>';

			if ($action == 1) { include("admin/users.php"); }
			

			else if ($action == 2) { include("admin/news.php"); }
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Please register or login using your credentials!</p>';
		header("Location: index.php?menu=6");
	}
?>