<div class="guidesPageSelection">

    <?php  

        // Prüft, die Seite, auf der man sich befindet noch weiter zurück kann, wenn nicht, wird der "back" button entfernt
        if (isset ($_GET["page"])) {
            if($_GET["page"] <= 1){
                // echo "hello";
            } else {
                echo "<div class='backpage'><a href='guides?";
                if (isset($_GET['role'])) {
                    echo "role=";
                    echo $_GET["role"];
                    echo "&championSelection=";
                    echo $_GET["championSelection"];
                    echo "&page=";
                    $nextPage = $_GET["page"] - 1;
                    echo $nextPage;
                } else {
                    echo "page=";
                    echo $page - 1;
                }
                echo "'>Back</a></div>";
            }
        } else {

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
                    if( $x == $_GET["page"] ){
                        echo "class='active' ";
                    } 
                    echo "href='guides?";
                    if (isset($_GET['role'])) {
                        echo "role=" . $_GET["role"] . "&championSelection=" . $_GET["championSelection"] . "&page=";
                        echo $x;
                    } else {
                        echo "&page=";
                        echo $x;
                    }
                    
                    echo "'>";
                    echo $x;
                    echo "</a>";
                }
            } else {
                // Prüft, ob Filter aktiv sind damit die URL richtig umgeschrieben wird
                if ( isset($_GET["role"]) ) {
                    // Prüft, ob die Seitenzahl, auf der man sich befindet, kleiner ist als der "starttocut" wert
                    if ( $_GET["page"] <= $startToCut ) {
                        for($x = 1; $x <= $startToCut + 1; $x++){
                            echo "<a ";
                                if( $x == $_GET["page"] ){
                                    echo "class='active' ";
                                }
                            echo "href='guides?";
                            echo "role=";
                            echo $_GET["role"];
                            echo "&championSelection=";
                            echo $_GET["championSelection"];
                            echo "&page=";
                            echo $x;
                            echo "'>";
                            echo $x;
                            echo "</a>";
                        }
                        echo "<a href='guides?";
                        echo "role=";
                        echo $_GET["role"];
                        echo "&championSelection=";
                        echo $_GET["championSelection"];
                        echo "&page=";
                        echo $maxPages;
                        echo "'>";
                        echo $maxPages;
                        echo "</a>";
                    } else if ( $_GET["page"] >= $startToCutEnd) { // Prüft ob die Seitenzahl grösser ist als der "starttocutEnd" wert
                        for($x = 1; $x <= $startToCut + 1; $x++){
                            $y = $maxPages - $startToCut + $x - 1;
                            echo "<a ";
                            if( $y == $_GET["page"] ){
                                echo "class='active'";
                            }
                            echo "href='guides?";
                            echo "role=";
                            echo $_GET["role"];
                            echo "&championSelection=";
                            echo $_GET["championSelection"];
                            echo "&page=";
                            echo $x + $maxPages - 5;
                            echo "'>";
                            echo $x + $maxPages - 5;
                            echo "</a>";
                        }
                    } else { // erstellt die Seiten die der Nutzer zum navigieren braucht (bsp: Seitenanzahl ist 7 also wird folgendes angezeigt: 5, 6, 7, 8, 9 )
                        for($x = 1; $x <= $pagedistance; $x++){
                            echo "<a ";
                            if( $_GET["page"] - $pagedistance + 2 + $x == $_GET["page"] ){
                                echo " class='active' ";
                            } 
                            echo "href='guides?";
                            echo "role=";
                            echo $_GET["role"];
                            echo "&championSelection=";
                            echo $_GET["championSelection"];
                            echo "&page=";
                            echo $_GET["page"] - $pagedistance + 2 + $x;
                            echo "'>";
                            echo $_GET["page"] - $pagedistance + 2 + $x;
                            echo "</a>";
                        }
                        echo "<a href='guides?";
                        echo "role=";
                        echo $_GET["role"];
                        echo "&championSelection=";
                        echo $_GET["championSelection"];
                        echo "&page=";
                        echo $maxPages;
                        echo "'>";
                        echo $maxPages;
                        echo "</a>";
                    }
                } else {
                    // Prüft, ob die Seitenzahl, auf der man sich befindet, kleiner ist als der "starttocut" wert
                    if ( $page <= $startToCut ) {
                        for($x = 1; $x <= $startToCut + 1; $x++){
                            echo "<a ";
                            if( $x == $page ){
                                echo "class='active' ";
                            }
                            echo "href='guides?";
                            echo "&page=";
                            echo $x;
                            echo "'>";
                            echo $x;
                            echo "</a>";
                        }
                        echo "<a href='guides?";
                        echo "page=";
                        echo $maxPages;
                        echo "'>";
                        echo $maxPages;
                        echo "</a>";
                    } else if ( $page >= $startToCutEnd) { // Prüft ob die Seitenzahl grösser ist als der "starttocutEnd" wert

                        for($x = 1; $x <= $startToCut + 1; $x++){
                            $y = $maxPages - $startToCut + $x - 1;
                            echo "<a ";
                            if( $y == $page ){
                                echo "class='active' ";
                            }
                            echo "href='guides?";
                            echo "&page=";
                            echo $x + $maxPages - 5;
                            echo "'>";
                            echo $x + $maxPages - 5;
                            echo "</a>";
                        }
                        
                    } else { // erstellt die Seiten die der Nutzer zum navigieren braucht (bsp: Seitenanzahl ist 7 also wird folgendes angezeigt: 5, 6, 7, 8, 9 )
                        for($x = 1; $x <= $pagedistance; $x++){
                            echo "<a ";
                            if( $page - $pagedistance + 2 + $x == $page ){
                                echo "class='active' ";
                            } 
                            echo "href='guides?";
                            echo "&page=";
                            echo $page - $pagedistance + 2 + $x;
                            echo "'>";
                            echo $page - $pagedistance + 2 + $x;
                            echo "</a>";
                        }
                        echo "<a href='guides?=";
                        echo $maxPages;
                        echo "'>";
                        echo $maxPages;
                        echo "</a>";
                    }
                }
            }

        ?>
    </div>

    <?php  
        // Prüft, die Seite, auf der man sich befindet noch weiter vorwärts kann, wenn nicht, wird der "next" button entfernt
        if (isset ($_GET["page"])) {
            if($_GET["page"] >= $maxPages){
                // echo "hello";
            } else {
                echo "<div class='nextpage'><a href='guides?";
                if (isset($_GET['role'])) {
                    echo "role=";
                    echo $_GET["role"];
                    echo "&championSelection=";
                    echo $_GET["championSelection"];
                    echo "&page=";
                    $nextPage = $_GET["page"] + 1;
                    echo $nextPage;
                    // echo $page + 1;
                } else {
                    echo "page=";
                    echo $page + 1;
                }
                echo "'>Next</a></div>";
            }
        } else {
            if ( $page >= $maxPages ) {

            } else {
                echo "<div class='nextpage'>";
                echo "<a href='guides?page=";
                echo $page + 1;
                echo "'>Next</a>";
            }
        }

    ?>

</div>