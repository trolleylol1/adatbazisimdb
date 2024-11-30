<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Be kell jelentkezned az értékeléshez!");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektmunka_imdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// type es id parameter megnezes 
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Hiányzó paraméterek!");
}

$type = $_GET['type'];
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    
    
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
        $stmt_ertekeles = $conn->prepare("INSERT INTO Ertekeles (felhasznalo_id, film_id, ertekeles) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ertekeles = VALUES(ertekeles)");
        $stmt_ertekeles->bind_param("iid", $felhasznalo_id, $id, $rating);
    } elseif ($type === 'series') {
        $stmt_ertekeles = $conn->prepare("INSERT INTO Ertekeles (felhasznalo_id, sorozat_id, ertekeles) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ertekeles = VALUES(ertekeles)");
        $stmt_ertekeles->bind_param("iid", $felhasznalo_id, $id, $rating);
    } else {
        die("Ismeretlen típus!");
    }

    if ($stmt_ertekeles->execute()) {
        echo "Értékelés sikeresen beküldve!";
    } else {
        echo "Hiba történt az értékelés beküldésekor: " . $stmt_ertekeles->error;
    }
    $stmt_ertekeles->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Értékelés</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="ui">
    <h1>Értékelés</h1>
    <form action="rating.php?type=<?= htmlspecialchars($type); ?>&id=<?= htmlspecialchars($id); ?>" method="POST">
        
        <label for="rating">Értékelés:</label>
        <input type="number" id="rating" name="rating" min="1" max="10" step="0.1" required>
        <button type="submit">Értékelés beküldése</button>
    </form>
    <button onclick="window.location.href='list.php';">Vissza a listához</button>
    </div>
</body>
</html>
