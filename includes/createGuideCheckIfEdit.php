<?php
    // Wenn bei guides.php auf edit geklickt wurde, es prüft die Daten und Berechtigungen
    if ( isset($_GET["action"]) ) {
        if ( $_GET["action"] == "edit" ) {
            // Guide ID in Variable speichern
            $guideID = $_GET['guide'];

            // Guide Daten holen
            $row = $instanz->showGuide($guideID);

            if ($row["userID"] == $userID || $_SESSION["role"] == "admin" ) { // Prüft ob der User berechtigt ist diesen Guide zu bearbeiten
                // Weiss existierende Variabeln Daten zu
                $titleOfGuide = $row["guideTitle"];
                $editor1 = $row["theGuide"];
                $chosenChampion = $row["champion"];
                $editMode = true;

                // Itembuild Daten holen
                $derBuild = $instanz->showBuild($guideID);

                if($derBuild != "NoBuild"){ // Wenn ein Guide vorhanden ist

                    $buildVorhanden = true;

                    // Anzahl der Verwendeten Sets herausfinden
                    if ($derBuild['set2'] == "") {
                        $anzahlSets = 1;
                    } else if ($derBuild['set3'] == ""){
                        $anzahlSets = 2;
                    } else if ($derBuild['set4'] == ""){
                        $anzahlSets = 3;
                    } else if ($derBuild['set5'] == ""){
                        $anzahlSets = 4;
                    } else if ($derBuild['set6'] == ""){
                        $anzahlSets = 5;
                    } else if ($derBuild['set7'] == ""){
                        $anzahlSets = 6;
                    } else if ($derBuild['set8'] == ""){
                        $anzahlSets = 7;
                    } else if ($derBuild['set9'] == ""){
                        $anzahlSets = 8;
                    } else {
                        $anzahlSets = 9;
                    }
                }
            } else {
                die("Du hast keine Berechtigung diesen Guide zu bearbeiten!");
            }
        }
    }

?>