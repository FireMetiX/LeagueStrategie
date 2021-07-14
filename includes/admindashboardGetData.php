<?php

    // Prüft, ob ein Admin angemeldet ist
    if ($_SESSION["isLoggedin"] == 1 && $_SESSION["role"] == "admin") {
        $guides = $instanz->showNewestGuides(); // Zeigt die neusten 3 Guides an
        $users = $instanz->showNewestUsers(); // Zeigt die neusten 3 User an

    } else {
        die("Du hast keine Berechtigung diese Page aufzurufen");
    }

?>