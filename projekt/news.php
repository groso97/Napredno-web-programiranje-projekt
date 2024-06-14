<?php

if (isset($action) && $action != '') {
	$query  = "SELECT * FROM news INNER JOIN pictures ON news.more_pictures = pictures.id";
	$query .= " WHERE news.id=" . $_GET['action'];
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
	print '
			<div class="news">
			<a href="news/' . $row['picture1'] . '" target="_blank"><img src="news/' . $row['picture1'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '"></a>
            <a href="news/' . $row['picture2'] . '" target="_blank"><img src="news/' . $row['picture2'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '"></a>
				<h2>' . $row['title'] . '</h2>
				<p>'  . $row['text'] . '</p>
				<time datetime="' . $row['created_at'] . '">' . pickerDateToMysql($row['created_at']) . '</time>
				<hr>
				<a href="index.php?menu=2">Back</a>
			</div>';
} else {
	print '<h1>NEWS</h1>';
	$query  = "SELECT * FROM news";
	$query .= " WHERE archive='NO'";
	$query .= " ORDER BY created_at DESC";
	$result = @mysqli_query($MySQL, $query);
	while ($row = @mysqli_fetch_array($result)) {
		print '
			<div class="news">
				<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>';
		if (strlen($row['text']) > 100) {
			echo substr(strip_tags($row['text']), 0, 100) . '... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">More</a>';
		} else {
			echo strip_tags($row['text']);
		}
		print '
				<time datetime="' . $row['created_at'] . '">' . pickerDateToMysql($row['created_at']) . '</time>
				<hr>
			</div>';
	}
}
