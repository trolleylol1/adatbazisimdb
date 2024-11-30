<!-- szorgalmas szineszek gomb -->

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

// Lekérdezzük a színészeket és megszámoljuk, hány filmben és sorozatban szerepeltek

$sql_szinesz = "
    SELECT 
        Szinesz.nev, 
        (COUNT(DISTINCT Szerepel.film_id) + COUNT(DISTINCT Szerepel.sorozat_id)) AS osszes_szereples
    FROM Szinesz
    LEFT JOIN Szerepel ON Szinesz.szinesz_id = Szerepel.szinesz_id
    GROUP BY Szinesz.nev
    ORDER BY osszes_szereples DESC
";
$result_szineszek = $conn->query($sql_szinesz);

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Színészek Listája</title>
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="ui">
    <h1>Színészek Listája</h1>
    <button onclick="window.location.href='ui.php'">Főoldal</button>
    <table>
        <thead>
            <tr>
                <th>Név</th>
                
                <th>Ennyiszer szerepelt filmben/sorozatban</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_szineszek->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nev']); ?></td>
                    <td><?= htmlspecialchars($row['osszes_szereples']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
            </div>
</body>
</html>
<?php
$conn->close();
?>
