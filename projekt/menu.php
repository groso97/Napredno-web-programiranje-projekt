<?php
print '
	<ul>
		<li><a href="index.php?menu=1">Home</a></li>
		<li><a href="index.php?menu=2">News</a></li>
		<li><a href="index.php?menu=3">Contact</a></li>
		<li><a href="index.php?menu=4">About</a></li>
		<li><a href="index.php?menu=5">Gallery</a></li>';

if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false') {
	print '
			<li><a href="index.php?menu=6">Register</a></li>
			<li><a href="index.php?menu=7">Login</a></li>';
} else if ($_SESSION['user']['valid'] == 'true') {
	print '
			<li><a href="index.php?menu=8">Admin</a></li>
			<li><a href="logout.php">Logout</a></li>';
}
print '
	<li><a href="index.php?menu=10">API(XML)</a></li>
	<li><a href="index.php?menu=11">API(JSON)</a></li>
	</ul>';
