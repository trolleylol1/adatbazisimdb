<!-- filmsorozat felvetelgomb -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Be kell jelentkezned az elem hozzáadásához!");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektmunka_imdb";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type']; // itt megkapja h most ez film v sorozat

    
    $felhasznalonev = $_SESSION['username'];
    $sql_user_id = "SELECT felhasznalo_id FROM Felhasznalo WHERE felhasznalonev = ?";
    $stmt_user = $conn->prepare($sql_user_id);
    $stmt_user->bind_param("s", $felhasznalonev);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    
    if ($result_user->num_rows === 0) {
        die("Érvénytelen felhasználónév!");
    }

    $user_data = $result_user->fetch_assoc();
    $felhasznalo_id = $user_data['felhasznalo_id'];

    if ($type === 'movie') {
        // film hozzaadas
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $duration = $_POST['duration'];
        $release_year = $_POST['release_year_movie'];
        $rating = $_POST['rating']; 

        $stmt = $conn->prepare("INSERT INTO Filmek (cim, mufaj, jatekido, megjelenes_eve) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $genre, $duration, $release_year);

        if ($stmt->execute()) {
            $film_id = $stmt->insert_id;
            $stmt_ertekeles = $conn->prepare("INSERT INTO Ertekeles (felhasznalo_id, film_id, ertekeles) VALUES (?, ?, ?)");
            $stmt_ertekeles->bind_param("iid", $felhasznalo_id, $film_id, $rating);
            $stmt_ertekeles->execute();
            echo "Film és értékelés sikeresen hozzáadva!";
        } else {
            echo "Hiba történt a film hozzáadásakor: " . $stmt->error;
        }
    } elseif ($type === 'series') {
        // sorozat hozzadas
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $seasons = $_POST['seasons'];
        $episodes = $_POST['episodes'];
        $rating = $_POST['rating'];  

        $stmt = $conn->prepare("INSERT INTO Sorozatok (cim, mufaj, evadok, reszek) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $genre, $seasons, $episodes);

        if ($stmt->execute()) {
            $sorozat_id = $stmt->insert_id;
            $stmt_ertekeles = $conn->prepare("INSERT INTO Ertekeles (felhasznalo_id, sorozat_id, ertekeles) VALUES (?, ?, ?)");
            $stmt_ertekeles->bind_param("iid", $felhasznalo_id, $sorozat_id, $rating);
            $stmt_ertekeles->execute();
            echo "Sorozat és értékelés sikeresen hozzáadva!";
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
