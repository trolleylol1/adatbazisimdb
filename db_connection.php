<?php
// ezdurva
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'projektmunka_imdb'; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Hiba az adatbázishoz való csatlakozáskor: " . $conn->connect_error);
}
?>