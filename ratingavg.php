<!-- atlagosertekelesgomb cuccos-->
<?php
session_start();
include 'db_connection.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['username'])) {
    echo "Kérlek jelentkezz be!";
    exit;
}

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

//a format ketto digitre kerekit mert az meno
$sql_filmek_atlag = "
    SELECT 
        FORMAT(AVG(Ertekeles.ertekeles), 2) AS atlag_ertekeles
    FROM Filmek
    JOIN Ertekeles ON Filmek.film_id = Ertekeles.film_id
";
$result_filmek_atlag = $conn->query($sql_filmek_atlag);
$row_filmek_atlag = $result_filmek_atlag->fetch_assoc();
$atlag_filmek_ertekeles = $row_filmek_atlag['atlag_ertekeles'];


$sql_sorozatok_atlag = "
    SELECT 
        FORMAT(AVG(Ertekeles.ertekeles), 2) AS atlag_ertekeles
    FROM Sorozatok
    JOIN Ertekeles ON Sorozatok.sorozat_id = Ertekeles.sorozat_id
";
$result_sorozatok_atlag = $conn->query($sql_sorozatok_atlag);
$row_sorozatok_atlag = $result_sorozatok_atlag->fetch_assoc();
$atlag_sorozatok_ertekeles = $row_sorozatok_atlag['atlag_ertekeles'];

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Átlag Értékelések</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<div id="ui">
<body>
    <h1>Átlagos Értékelések</h1>
    <table>
        <thead>
            <tr>
                <th>Típus</th>
                <th>Átlagos Értékelés</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Filmek</td>
                <td><?= htmlspecialchars($atlag_filmek_ertekeles ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td>Sorozatok</td>
                <td><?= htmlspecialchars($atlag_sorozatok_ertekeles ?? 'N/A'); ?></td>
            </tr>
        </tbody>
    </table>
    <button onclick="window.location.href='ui.php'">Vissza a főoldalra</button>
</div>
</body>
</html>
<?php
$conn->close();
?>
