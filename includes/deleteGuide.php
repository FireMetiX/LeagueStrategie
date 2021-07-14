<?php
    include_once("../includes/credentials.php");
    include_once("../class/pdoconn.class.php");

    session_start();

    $instanz = new Dbh($host, $user, $pass, $dbname);

    $role = $_SESSION['role'];

    if ( isset($_POST['action']) ) {
        if ($_POST["action"] == "deleteConfirm") {
            if ($instanz->checkSelected($_POST['guideID']) == $_SESSION['userID'] || $_SESSION['role'] == "admin") { // Wenn rolle = Admin oder Guide vom User erstellt worden ist
                // echo "It worked!";
                $instanz->deleteSelected($_POST['guideID']); // Lösche ausgewählten Guide
                echo true;
            } else {
                // echo "Didn't work!";
                echo false;
            }
        }
    }
?>