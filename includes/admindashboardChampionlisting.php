<?php
    // Guides werden aufgelistet
    if($guides != "NoGuides"){
        foreach( $guides as $guide ) {
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