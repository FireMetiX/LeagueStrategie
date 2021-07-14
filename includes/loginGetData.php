<?php
    // Wenn Logout geklickt wurde
    if (isset($_GET["action"]) && $_GET["action"] == "logout") {
        // echo "logout";
        session_destroy();
    }

    // Prüft ob der user eingelogt ist.
    if ($_SESSION["isLoggedin"] == 1) {
        header("Location: ../index.php");
    }
?>