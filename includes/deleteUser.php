<?php
    include_once("../includes/credentials.php");
    include_once("../class/pdoconn.class.php");

    session_start();

    $instanz = new Dbh($host, $user, $pass, $dbname);

    $role = $_SESSION['role'];

    if ( isset($_POST['action']) ) {
        if ($_POST["action"] == "deleteConfirm") {
            if ($role == "admin") { // Wenn rolle = Admin 
                // echo "It worked!";
                $instanz->deleteUserAndGuides($_POST["userID"]); // Löscht den ausgewählten User sammt alle von Ihm erstellten Guides
                echo true;
            } else {
                // echo "Didn't work!";
                echo false;
            }
        }
    }
?>