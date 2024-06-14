<?php
$api_key = 'd7a2a8bc45908415f7e99f0039dcaf1d';


function sendRequest($method, $params)
{
    global $api_key;
    $url = 'http://ws.audioscrobbler.com/2.0/?method=' . $method . '&api_key=' . $api_key . '&format=xml&' . http_build_query($params);
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        return FALSE;
    }
    return simplexml_load_string($response);
}





$artist_name = '';
$artist_info = '';
$top_albums = '';
$top_tracks = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['artist_name'])) {
    $artist_name = $_POST['artist_name'];

    $artist_info = sendRequest('artist.getinfo', ['artist' => $artist_name]);
    if ($artist_info === FALSE || empty($artist_info->artist)) {
        $error_message = "There is no information about that specific artist.";
    } else {
        $top_albums = sendRequest('artist.gettopalbums', ['artist' => $artist_name]);
        $top_tracks = sendRequest('artist.gettoptracks', ['artist' => $artist_name]);

        if ($top_albums === FALSE) {
            $error_message = "There is no information about albums.";
        }

        if ($top_tracks === FALSE) {
            $error_message = "There is no information about tracks.";
        }
    }
}




print '
<main>
    <div class="container-xml">
        <h1 class="heading">Last.fm Artist Search</h1>
        <form class="json-forma" method="POST" action="">
            <input type="text" name="artist_name" placeholder="Search for an artist" value="' . htmlspecialchars($artist_name) . '" required>
            <input type="submit" value="Search">
        </form>';

if ($error_message) {
    print '<p class="error-message">' . htmlspecialchars($error_message) . '</p>';
}

if (!empty($artist_info) && !empty($artist_info->artist)) {
    print '
        <div class="artist-info">
            <div class="info-box">
                <h2>' . htmlspecialchars($artist_info->artist->name) . '</h2>
                <p>' . htmlspecialchars(strip_tags($artist_info->artist->bio->summary)) . '</p>
            </div>
            <div class="albums-tracks-container">';

    if (!empty($top_albums->topalbums->album)) {
        print '
                <div class="albums-column">
                    <h2>Top Albumi</h2>
                    <ul class="top-albums">';
        $albums_count = 0;
        foreach ($top_albums->topalbums->album as $album) {
            $album_name = htmlspecialchars($album->name);
            $album_image = htmlspecialchars($album->image[2]);
            if (!empty($album_name) && !empty($album_image) && $album_image != '[object Object]') {
                print '<li>';
                print '<p>' . $album_name . '</p>';
                print '<img src="' . $album_image . '" alt="' . $album_name . '">';
                print '</li>';
                $albums_count++;
            }
            if ($albums_count >= 5) break;
        }
        print '      </ul>
                </div>';
    }

    if (!empty($top_tracks->toptracks->track)) {
        print '
                <div class="tracks-column">
                    <h2>Top Pjesme</h2>
                    <ul class="top-tracks">';
        $tracks_count = 0;
        foreach ($top_tracks->toptracks->track as $track) {
            if ($tracks_count >= 15) break;
            print '<li>' . ($tracks_count + 1) . '. ' . htmlspecialchars($track->name) . '</li>';
            $tracks_count++;
        }
        print '      </ul>
                </div>';
    }

    print '
            </div>
        </div>';
}

print '
    </div>
</main>';
