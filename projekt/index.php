<?php
session_start();
$MySQL = mysqli_connect("localhost", "root", "", "konekcija") or die('Error connecting to MySQL server.');
if (isset($_GET['menu'])) {
	$menu = (int)$_GET['menu'];
}
if (isset($_GET['action'])) {
	$action = (int)$_GET['action'];
}

if (!isset($_POST['_action_'])) {
	$_POST['_action_'] = FALSE;
}
if (!isset($menu)) {
	$menu = 1;
}

include_once("function.php");


print '
<!DOCTYPE html>
<html lang="en">
<head>
<title>2021 Ford® Mustang</title>
<link rel="stylesheet" href="style.css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="description" content="Ovo je projektni zadatak za Web aplikacije">
<meta name="keywords" content="Ključne riječi o Mustangu">
<meta name="author" content="Goran Roso">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/x-icon" href="images/ford.ico">
</head>
<body>

<header>
		<div';
if ($menu > 0) {
	print 'class="hero-image"';
}
print '></div>
		<nav>';
include("menu.php");
print '</nav>
</header>';
if (isset($_SESSION['message'])) {
	print $_SESSION['message'];
	unset($_SESSION['message']);
}
print '
<main>';


if (!isset($menu) || $menu == 1) {
	include("home.php");
} else if ($menu == 2) {
	include("news.php");
} else if ($menu == 3) {
	include("contact.php");
} else if ($menu == 4) {
	include("about.php");
} else if ($menu == 5) {
	include("gallery.php");
} else if ($menu == 6) {
	include("register.php");
} else if ($menu == 7) {
	include("login.php");
} else if ($menu == 8) {
	include("admin.php");
} else if ($menu == 9) {
	include("logout.php");
} else if ($menu == 10) {
	include("api-xml.php");
} else if ($menu == 11) {
	include("api-json.php");
}



print '
</main>
<footer>
<p>Copyright &copy; 2024 Goran Roso<a href="https://github.com/fanaticcro97/Projektni-zadatak-PHP"><img src="images/GitHub-Mark-Light-32px.png" title="Github" alt="Github"></a></p>
</footer>
</body>
</html>';
