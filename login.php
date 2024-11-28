<?php
// Hibák megjelenítése fejlesztéshez
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";  // Adatbázis-felhasználónév
$password = "";      // Adatbázis-jelszó
$dbname = "projektmunka_imdb"; // Adatbázis neve

$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Felhasználónév és jelszó bekérése
    $username = $_POST['felhasznalonev'];
    $password = $_POST['jelszo'];

    // Ellenőrizzük, hogy a mezők nem üresek-e
    if (empty($username) || empty($password)) {
        die("A felhasználónév és a jelszó megadása kötelező!");
    }

    // Felhasználó lekérdezése az adatbázisból
    $stmt = $conn->prepare("SELECT felhasznalo_id, jelszo, nev FROM felhasznalo WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Ha van ilyen felhasználónév, lekérjük az adatokat
        $stmt->bind_result($id, $stored_password, $name);
        $stmt->fetch();

        // Egyszerű jelszó ellenőrzés
        if ($password === $stored_password) {
            // Sikeres bejelentkezés
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $id;
            $_SESSION['name'] = $name;

            echo "Sikeres bejelentkezés! Üdvözöllek, " . htmlspecialchars($name) . "!";
            header("Location: ui.php");  // Átirányítás az alkalmazás főoldalára
            exit();
        } else {
            echo "Hibás jelszó!";
        }
    } else {
        echo "Nincs ilyen felhasználónév!";
    }

    $stmt->close();
}

$conn->close();
?>
