<?php
    // Verbindung mit Datenbank herstellen
    $instanz = new Dbh($host, $user, $pass, $dbname);

    // Variabeln definieren
    $nofilter = true;
    $role = "";
    $champion = "";

    // Prüfen, ob schon Page existiert
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $guidesPerPage = 7;
    $maxPages = 1;
    $currentPage = $page * $guidesPerPage - $guidesPerPage;

    // Reset URL
    if ( isset($_GET["role"]) or isset($_GET["championSelection"])) {
        if ($_GET["role"] == "all" && $_GET["championSelection"] == "0"){
            header("Location: ./guides");
        } else {
            $role = $_GET["role"];
            $champion = $_GET["championSelection"];
            $nofilter = false;
        }
    }

    // Prüfen ob Filter aktiv sind
    if ($nofilter == 1) {
        // Die showGuides Methode wird ausgeführt keinem Filter
        $guides = $instanz->showGuides(0, $role, $champion, $currentPage, $guidesPerPage);
        if(isset($guides[0])){
            $maxPages = $guides[0]; // Gibt bescheid, wie viele Seiten die Guides in anspruch nehmen werden.
        } else {
            $maxPages = 0; // Wenn es keine Seiten gibt
        }

    } else {
        if ($role == "all" ) {
            // Die showGuides Methode wird ausgeführt mit einem Champion Filter
            $guides = $instanz->showGuides(1, $role, $champion, $currentPage, $guidesPerPage);
            if(isset($guides[0])){
                $maxPages = $guides[0]; // Gibt bescheid, wie viele Seiten die Guides in anspruch nehmen werden.
            } else {
                $maxPages = 0; // Wenn es keine Seiten gibt
            }

        } else if ($champion == "0") {
            // Die showGuides Methode wird ausgeführt mit einem Rollen Filter
            $guides = $instanz->showGuides(2, $role, $champion, $currentPage, $guidesPerPage);
            if(isset($guides[0])){
                $maxPages = $guides[0]; // Gibt bescheid, wie viele Seiten die Guides in anspruch nehmen werden.
            } else {
                $maxPages = 0; // Wenn es keine Seiten gibt
            }

        } else {
            // Die showGuides Methode wird ausgeführt mit 2 aktiven Filtern
            $guides = $instanz->showGuides(3, $role, $champion, $currentPage, $guidesPerPage);
            if(isset($guides[0])){
                $maxPages = $guides[0]; // Gibt bescheid, wie viele Seiten die Guides in anspruch nehmen werden.
            } else {
                $maxPages = 0; // Wenn es keine Seiten gibt
            }
        }
    }

?>