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
        $nachname = desinfect($_POST["nachname"]);
        $vorname = desinfect($_POST["vorname"]);
        $username = desinfect($_POST["username"]);
        $passwort = desinfect($_POST["password"]);
        $email = desinfectEmail($_POST["email"]);

        // Passwort Hashen
        $hashPassword = password_hash($passwort,PASSWORD_DEFAULT);
        // Register Methode aufrufen
        echo json_encode($instanz->register($nachname, $vorname, $username, $hashPassword, $email, 1));

    };