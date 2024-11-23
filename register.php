<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root"; // Ide jön az adatbázis-felhasználónév
$password = "";         // Ide jön az adatbázis-jelszó
$databasename = "IMDB";                 // Az adatbázis neve

// Adatbázis kapcsolat
$conn = new mysqli($servername, $username, $password, $databasename);

// Kapcsolódási hiba ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['felhasznalonev'];
    $password = $_POST['jelszo'];

    // Felhasználónév ellenőrzése
    $stmt = $conn->prepare("SELECT id FROM felhasznalok WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Ez a felhasználónév foglalt, kérlek adj meg másikat!");
    }
    $stmt->close();

    // Új felhasználó hozzáadása
    $stmt = $conn->prepare("INSERT INTO felhasznalok (felhasznalonev, jelszo) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "Sikeres regisztráció!";
    } else {
        echo "Hiba történt: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

