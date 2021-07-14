<?php 

    include_once("../includes/credentials.php");
    include_once("../class/pdoconn.class.php");

    session_start();
    
    $instanz = new Dbh($host, $user, $pass, $dbname);

        // Variabeln definieren
        $nofilter = true;
        $role = $_POST['role'];
        $champion = $_POST['champion'];
        $page = $_POST['page'];
    
        $guidesPerPage = 7;
        $maxPages = 1;
        $currentPage = $page * $guidesPerPage - $guidesPerPage;
    
        // Reset URL
        if ( isset($_POST["role"]) or isset($_POST["champion"])) {
            if ($_POST["role"] == "all" && $_POST["champion"] == "0"){

            } else {
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

    // Guides werden aufgelistet
    if(isset($guides[0])){
        foreach( $guides[1] as $guide ) {
            echo "<a href='guide?guide=" . $guide["ID"] . "'><div class='guide'>";
            echo "<img src='../img/champion/tiles/" . $guide["champion"] . "_0.jpg' alt='Picture of " . $guide["champion"] . "'>"; // Bild vom Champion
            echo "<div class='guideInfos'>";
            echo "<p class='title'>" . $guide["guideTitle"] . "</p>"; // Titel des Guides
            echo "<p class='smallInfo'>By <span>" . $guide["username"] . "</span> | posted in " . $guide["createDate"] . "</p>"; // Weitere Informationen des Guides
            echo "</div>";
            echo "</div></a>";
            if ($_SESSION["userID"] == $guide["userID"] || $_SESSION["role"] == "admin") { // Prüft ob ein Admin oder der User des erstellten Guides angemeldet ist
                echo "<div class='guideUserEdit'>";
                echo "<div class='guideEdit'><a href='createGuide?action=edit&guide=" . $guide["ID"] . "'><i class='far fa-edit'></i></a></div>";  // Fügt dem Guide ein Edit Button hinzu
                echo "<div class='guideDelete' data-guideid='" . $guide["ID"] . "'><i class='far fa-trash-alt'></i></div></div>"; 
            }
        }
    } else { // Gibt ein error raus, wenn keine Guides vorhanden sind
        echo "<div class='displayerrors'>"; 
            echo "<p>Keine Guides vorhanden!</p>";
        echo "</div>";
    }


?>

<div class="guidesPageSelection">

    <?php  

        // Prüft, die Seite, auf der man sich befindet noch weiter zurück kann, wenn nicht, wird der "back" button entfernt
        if ($page <= 1){

        } else {
            $nextPage = $page - 1;
            echo "<div class='backpage'><a href='guides?";
            if ($role != "all" || $champion != 0) {
                echo "role=" . $role . "&championSelection=" . $champion . "&page=" . $nextPage;
            } else {
                echo "page=" . $nextPage;
            }
            echo "'>Back</a></div>";
        }

    ?>

    <div class="pages">

    <?php

        // Definiere einige Variabeln
        $startToCut = 4;
        $pagedistance = 5;
        $startToCutEnd = $maxPages - 4;

        // Prüft, wenn nicht mehr als 4 Seiten existieren, soll es eine simplere Ansicht für Seiten anzeigen
        if ( $maxPages <= 4) {
            for ($x = 1; $x <= $maxPages; $x++) {
                echo "<a ";
                if( $x == $page ){
                    echo "class='active' ";
                } 
                echo "href='guides?";
                if ($role != "all" ) {
                    echo "role=" . $role . "&championSelection=" . $champion . "&page=" . $x;
                } else {
                    echo "&page=" . $x;
                }
                
                echo "'>" . $x . "</a>";
            }
        } else {
            // Prüft, ob Filter aktiv sind damit die URL richtig umgeschrieben wird
            if ( $role != "all" ) {
                // Prüft, ob die Seitenzahl, auf der man sich befindet, kleiner ist als der "starttocut" wert
                if ( $page <= $startToCut ) {
                    for($x = 1; $x <= $startToCut + 1; $x++){
                        echo "<a ";
                            if( $x == $page ){
                                echo "class='active' ";
                            }
                        echo "href='guides?role=" . $role . "&championSelection=" . $champion . "&page=" . $x . "'>" . $x . "</a>";
                    }
                    echo "<a href='guides?role=" . $role . "&championSelection=" . $champion . "&page=" . $maxPages . "'>" . $maxPages . "</a>";

                } else if ( $page >= $startToCutEnd) { // Prüft ob die Seitenzahl grösser ist als der "starttocutEnd" wert
                    for($x = 1; $x <= $startToCut + 1; $x++){
                        $y = $maxPages - $startToCut + $x - 1;
                        $z = $x + $maxPages - 5;
                        echo "<a ";
                        if( $y == $page ){
                            echo "class='active'";
                        }
                        echo "href='guides?role=" . $role . "&championSelection=" . $champion . "&page=" . $z . "'>" . $z . "</a>";
                    }
                } else { // erstellt die Seiten die der Nutzer zum navigieren braucht (bsp: Seitenanzahl ist 7 also wird folgendes angezeigt: 5, 6, 7, 8, 9 )
                    for($x = 1; $x <= $pagedistance; $x++){
                        $y = $page - $pagedistance + 2 + $x;
                        echo "<a ";
                        if( $page - $pagedistance + 2 + $x == $page ){
                            echo " class='active' ";
                        } 
                        echo "href='guides?role=" . $role . "&championSelection=" . $champion . "&page=" . $y . "'>" . $y . "</a>";
                    }
                    echo "<a href='guides?role=" . $role . "&championSelection=" . $champion . "&page=" . $maxPages . "'>" . $maxPages . "</a>";
                }
            } else { // Wenn keine Filter aktiv sind
                // Prüft, ob die Seitenzahl, auf der man sich befindet, kleiner ist als der "starttocut" wert
                if ( $page <= $startToCut ) {
                    for($x = 1; $x <= $startToCut + 1; $x++){
                        echo "<a ";
                        if( $x == $page ){
                            echo "class='active' ";
                        }
                        echo "href='guides?&page=" . $x . "'>" . $x . "</a>";
                    }
                    echo "<a href='guides?page=" . $maxPages . "'>" . $maxPages . "</a>";
                } else if ( $page >= $startToCutEnd) { // Prüft ob die Seitenzahl grösser ist als der "starttocutEnd" wert

                    for($x = 1; $x <= $startToCut + 1; $x++){
                        $y = $maxPages - $startToCut + $x - 1;
                        $z = $x + $maxPages - 5;
                        echo "<a ";
                        if( $y == $page ){
                            echo "class='active' ";
                        }
                        echo "href='guides?&page=" . $z . "'>" . $z . "</a>";
                    }
                    
                } else { // erstellt die Seiten die der Nutzer zum navigieren braucht (bsp: Seitenanzahl ist 7 also wird folgendes angezeigt: 5, 6, 7, 8, 9 )
                    for($x = 1; $x <= $pagedistance; $x++){
                        $y = $page - $pagedistance + 2 + $x;
                        echo "<a ";
                        if( $page - $pagedistance + 2 + $x == $page ){
                            echo "class='active' ";
                        } 
                        echo "href='guides?&page=" . $y . "'>" . $y . "</a>";            
                    }
                    echo "<a href='guides?=" . $maxPages . "'>" . $maxPages . "</a>";
                }
            }
        }

    ?>

    </div>

    <?php  

        // Prüft, die Seite, auf der man sich befindet noch weiter vorwärts kann, wenn nicht, wird der "next" button entfernt
        if ($page >= $maxPages){

        } else {
            $nextPage = $page + 1;
            echo "<div class='nextpage'><a href='guides?";
            if ($role != "all" || $champion != 0) {
                echo "role=" . $role . "&championSelection=" . $champion . "&page=" . $nextPage;
            } else {
                echo "page=" . $nextPage;
            }
            echo "'>Next</a></div>";
        }

    ?>

</div>