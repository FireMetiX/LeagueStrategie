<?php
    // Prüft, ob die der eintrag "isLoggedin" schon existiert
    if (isset($_SESSION["isLoggedin"])) {
    } else {
        $_SESSION["isLoggedin"] = false;
    }
    // Prüft, ob die der eintrag "role" schon existiert
    if (isset($_SESSION["role"])) {
    } else {
        $_SESSION["role"] = "none";
    }
        // Prüft, ob die der eintrag "userID" schon existiert
    if (isset($_SESSION["userID"])) {
    } else {
        $_SESSION["userID"] = "none";
    }
?>