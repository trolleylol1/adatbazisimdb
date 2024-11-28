<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Az adatbázis-felhasználónév
$password = "";     // Az adatbázis-jelszó
$databasename = "projektmunka_imdb"; // Az adatbázis neve

// Adatbázis kapcsolat
$conn = new mysqli($servername, $username, $password, $databasename);

// Kapcsolódási hiba ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['felhasznalonev'];
    $password = $_POST['jelszo'];
    $name = $_POST['nev']; // Új mező a névhez

    // Ellenőrzés: üres mezők
    if (empty($username) || empty($password) || empty($name)) {
        die("Minden mezőt ki kell tölteni!");
    }

    // Felhasználónév egyediségének ellenőrzése
    $stmt = $conn->prepare("SELECT felhasznalo_id FROM felhasznalo WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Ez a felhasználónév már foglalt, kérlek válassz másikat!");
    }
    $stmt->close();

    // Új felhasználó hozzáadása
    $stmt = $conn->prepare("INSERT INTO felhasznalo (felhasznalonev, jelszo, nev) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $name);

    if ($stmt->execute()) {
        echo "Sikeres regisztráció!";
    } else {
        echo "Hiba történt a regisztráció során: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>


