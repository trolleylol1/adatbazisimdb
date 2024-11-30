<!--regisztracio gomb -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; 
$password = "";     
$databasename = "projektmunka_imdb"; 

$conn = new mysqli($servername, $username, $password, $databasename);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['felhasznalonev'];
    $password = $_POST['jelszo'];
    $name = $_POST['nev']; 

    
    if (empty($username) || empty($password) || empty($name)) {
        die("Minden mezőt ki kell tölteni!");
    }

    // megnezi hogy letezik e mar ez a username
    $stmt = $conn->prepare("SELECT felhasznalo_id FROM felhasznalo WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Ez a felhasználónév már foglalt, kérlek válassz másikat!");
    }
    $stmt->close();

    
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


