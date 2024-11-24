<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Be kell jelentkezned az elem hozzáadásához!");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IMDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type']; // "movie" vagy "series"

    if ($type === 'movie') {
        // Film hozzáadása
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $duration = $_POST['duration'];
        $release_year = $_POST['release_year_movie'];

        $stmt = $conn->prepare("INSERT INTO filmek (cim, mufaj, jatekido, megjelenes_eve) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $genre, $duration, $release_year);

        if ($stmt->execute()) {
            echo "Film sikeresen hozzáadva!";
        } else {
            echo "Hiba történt a film hozzáadásakor: " . $stmt->error;
        }
    } elseif ($type === 'series') {
        // Sorozat hozzáadása
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $seasons = $_POST['seasons'];
        $episodes = $_POST['episodes'];

        $stmt = $conn->prepare("INSERT INTO sorozatok (cim, mufaj, evadok, reszek) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $genre, $seasons, $episodes);

        if ($stmt->execute()) {
            echo "Sorozat sikeresen hozzáadva!";
        } else {
            echo "Hiba történt a sorozat hozzáadásakor: " . $stmt->error;
        }
    } else {
        echo "Ismeretlen típus!";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hozzáadás</title>
</head>
<body>
    <button onclick="window.location.href='ui.php';">Vissza a főoldalra</button>
</body>
</html>
