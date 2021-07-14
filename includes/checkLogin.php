<?php 
    header('Content-Type: application/json');
    include_once("functions.inc.php");
    include_once("credentials.php");
    include_once("../class/pdoconn.class.php");

    session_start();

    $instanz = new Dbh($host, $user, $pass, $dbname);

    // Prüfen, ob auf Submit geklickt wurde
    if (isset($_POST["submit"])) {

        // Values speichern und desinfizieren
        $username = desinfect($_POST["username"]);
        $passwort = desinfect($_POST["password"]);

        // Login Methode aufrufen
        echo json_encode($instanz->login($username, $passwort, 1));

    };