<?php
session_start();
session_unset();  // Törli a session változókat
session_destroy();  // Megsemmisíti a session-t

// Átirányítás a főoldalra (vagy bármelyik másik oldalra)
header("Location: ui.php");
exit();
?>