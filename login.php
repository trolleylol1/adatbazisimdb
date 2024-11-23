<?php
// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";  // vagy másik adatbázis felhasználónév
$password = "";      // vagy az adatbázis jelszava
$dbname = "IMDB";    // vagy a saját adatbázis neve

$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizzük a kapcsolatot
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Felhasználónév és jelszó bekérése
    $username = $_POST['felhasznalonev'];
    $password = $_POST['jelszo'];

    // Ellenőrizzük, hogy a felhasználónév és jelszó nem üres-e
    if (empty($username) || empty($password)) {
        die("A felhasználónév és jelszó megadása kötelező!");
    }

    // Ellenőrizzük, hogy létezik-e a felhasználónév
    $stmt = $conn->prepare("SELECT id, jelszo FROM felhasznalok WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Ha van ilyen felhasználónév, lekérjük az adatokat
        $stmt->bind_result($id, $stored_password);
        $stmt->fetch();

        // Ellenőrizzük, hogy a megadott jelszó megegyezik-e a tárolt jelszóval
        if ($password === $stored_password) {
            echo "Sikeres bejelentkezés! Üdvözöllek, " . htmlspecialchars($username);
            // Itt célszerű lenne session-t használni a bejelentkezett felhasználó azonosításához
            $_SESSION['username'] = $username;
            header("Location: ui.php");  // Itt cseréld le a cél URL-re, ha másik oldalra szeretnéd irányítani
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