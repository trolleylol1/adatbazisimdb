<?php
// Adatbázis kapcsolat beállításai
$host = 'localhost'; // Szerver
$username = 'root'; // Felhasználónév (alapértelmezett: root)
$password = ''; // Jelszó (XAMPP alatt általában üres)
$database = 'projektmunka_imdb'; // Adatbázis neve

// Kapcsolat létrehozása
$conn = new mysqli($host, $username, $password, $database);

// Hiba ellenőrzése
if ($conn->connect_error) {
    die("Hiba az adatbázishoz való csatlakozáskor: " . $conn->connect_error);
}
?>