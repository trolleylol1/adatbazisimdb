<?php
session_start();
include 'db_connection.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['username'])) {
    echo "Kérlek jelentkezz be!";
    exit;
}

// Aktuális felhasználó
$felhasznalonev = $_SESSION['username'];

// Lekérjük a felhasználó ID-ját
$sql_user_id = "SELECT felhasznalo_id FROM Felhasznalo WHERE felhasznalonev = ?";
$stmt_user = $conn->prepare($sql_user_id);
$stmt_user->bind_param("s", $felhasznalonev);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 0) {
    echo "Érvénytelen felhasználónév!";
    exit;
}

$user_data = $result_user->fetch_assoc();
$felhasznalo_id = $user_data['felhasznalo_id'];

$sql_filmek = "
    SELECT 
        Filmek.cim,
        Filmek.mufaj,
        Filmek.jatekido,
        Filmek.megjelenes_eve,
        Ertekeles.ertekeles AS sajat_ertekeles
    FROM Filmek
    LEFT JOIN Ertekeles 
        ON Filmek.film_id = Ertekeles.film_id 
        AND Ertekeles.felhasznalo_id = ?  -- Csak a bejelentkezett felhasználó értékelése
";
$stmt_filmek = $conn->prepare($sql_filmek);
$stmt_filmek->bind_param("i", $felhasznalo_id);
$stmt_filmek->execute();
$result_filmek = $stmt_filmek->get_result();

$sql_sorozatok = "
    SELECT 
        Sorozatok.cim,
        Sorozatok.mufaj,
        Sorozatok.evadok,
        Sorozatok.reszek,
        Ertekeles.ertekeles AS sajat_ertekeles
    FROM Sorozatok
    LEFT JOIN Ertekeles 
        ON Sorozatok.sorozat_id = Ertekeles.sorozat_id 
        AND Ertekeles.felhasznalo_id = ?  -- Csak a bejelentkezett felhasználó értékelése
";
$stmt_sorozatok = $conn->prepare($sql_sorozatok);
$stmt_sorozatok->bind_param("i", $felhasznalo_id);
$stmt_sorozatok->execute();
$result_sorozatok = $stmt_sorozatok->get_result();

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div id="ui">
    <title>Filmek és Sorozatok</title>
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
    <h1>Filmek és Sorozatok Listája</h1>
    <button onclick="window.location.href='ui.php'">Főoldal</button>
    
    <!-- Filmek táblázata -->
    <h2>Filmek</h2>
<table>
    <thead>
        <tr>
            <th>Cím</th>
            <th>Műfaj</th>
            <th>Játékidő (perc)</th>
            <th>Megjelenés Éve</th>
            <th>Értékelés</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result_filmek->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['cim']); ?></td>
                <td><?= htmlspecialchars($row['mufaj']); ?></td>
                <td><?= htmlspecialchars($row['jatekido'] ?? 'N/A'); ?></td>
                <td><?= htmlspecialchars($row['megjelenes_eve'] ?? 'N/A'); ?></td>
                <td><?= htmlspecialchars($row['sajat_ertekeles'] ?? 'Még nem értékelted'); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
    
    <!-- Sorozatok táblázata -->
    <h2>Sorozatok</h2>
<table>
    <thead>
        <tr>
            <th>Cím</th>
            <th>Műfaj</th>
            <th>Évadok</th>
            <th>Részek Száma</th>
            <th>Értékelés</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result_sorozatok->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['cim']); ?></td>
                <td><?= htmlspecialchars($row['mufaj']); ?></td>
                <td><?= htmlspecialchars($row['evadok']); ?></td>
                <td><?= htmlspecialchars($row['reszek']); ?></td>
                <td><?= htmlspecialchars($row['sajat_ertekeles'] ?? 'Még nem értékelted'); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
    </div>
</body>
</html>
