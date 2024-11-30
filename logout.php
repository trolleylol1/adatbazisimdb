<!--kijelentkezes gomb  -->
<?php
session_start();
session_unset();  // session cuccait torli
session_destroy();  

header("Location: ui.php");
exit();
?>