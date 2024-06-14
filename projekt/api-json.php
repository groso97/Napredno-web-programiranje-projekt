<?php

$publicKey = '8e1094cbb7762bc84b503998aaaaedf5';
$privateKey = '63f3e0d5af1b9808872f3cc2ecf92a54b784d9c7';

function generateHash($publicKey, $privateKey, $timestamp)
{
    return md5($timestamp . $privateKey . $publicKey);
}


function fetchCharacters($query, $publicKey, $privateKey)
{
    $timestamp = time();
    $hash = generateHash($publicKey, $privateKey, $timestamp);

    $url = "https://gateway.marvel.com:443/v1/public/characters?nameStartsWith=" . urlencode($query) . "&ts=$timestamp&apikey=$publicKey&hash=$hash";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$characters = [];
$query = '';

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $characters = fetchCharacters($query, $publicKey, $privateKey);
}

print '
<main>
    <div class="container">
        <h1 class="heading">Marvel Character Search</h1>
        <form class="json-forma" method="POST" action="">
            <input type="text" name="query" placeholder="Search for a character" value="' . htmlspecialchars($query) . '" required>
            <input type="submit" value="Search">
        </form>
        <div class="character-list">';

if (isset($_POST['query'])) {
    if (isset($characters['data']['results']) && !empty($characters['data']['results'])) {
        $withDescription = [];
        $withoutDescription = [];

        foreach ($characters['data']['results'] as $character) {
            if (isset($character['thumbnail']) && strpos($character['thumbnail']['path'], 'image_not_available') === false) {
                if (isset($character['description']) && !empty($character['description'])) {
                    $withDescription[] = $character;
                } else {
                    $withoutDescription[] = $character;
                }
            }
        }

        $allCharacters = array_merge($withDescription, $withoutDescription);
        $allCharacters = array_slice($allCharacters, 0, 12);

        foreach ($allCharacters as $character) {
            print "
            <div class='character'>
                <h2>" . htmlspecialchars($character['name']) . "</h2>";
            if (isset($character['thumbnail'])) {
                $thumbnail = $character['thumbnail']['path'] . '/landscape_xlarge.' . $character['thumbnail']['extension'];
                print "
                <img src='" . htmlspecialchars($thumbnail) . "' alt='" . htmlspecialchars($character['name']) . "'>";
            }
            if (isset($character['description']) && !empty($character['description'])) {
                $description = strip_tags($character['description']);
                print "
                <p>" . htmlspecialchars($description) . "</p>";
            } else {
                print "
                <p>No description available.</p>";
            }
            print "
            </div>";
        }
    } else {
        print "
        <p class='no-characters'>No characters found. Try a different search term.</p>";
    }
}

print '
        </div>
    </div>
</main>';
