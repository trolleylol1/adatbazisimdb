<!-- bejelentkezesgomb -->
<?php
//
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "projektmunka_imdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST['felhasznalonev'];
    $password = $_POST['jelszo'];

    if (empty($username) || empty($password)) {
        die("A felhasználónév és a jelszó megadása kötelező!");
    }

    // felhasnzalo ellenorzese
    $stmt = $conn->prepare("SELECT felhasznalo_id, jelszo, nev FROM felhasznalo WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // ha egyezik a username akk jo
        $stmt->bind_result($id, $stored_password, $name);
        $stmt->fetch();

        
        if ($password === $stored_password) {
            // hurra login
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $id;
            $_SESSION['name'] = $name;

            echo "Sikeres bejelentkezés! Üdvözöllek, " . htmlspecialchars($name) . "!";
            header("Location: ui.php"); 
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
