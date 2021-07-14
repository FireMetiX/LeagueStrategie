<?php 
    header('Content-Type: application/json');
    include_once("functions.inc.php");
    include_once("credentials.php");
    include_once("../class/pdoconn.class.php");

    session_start();

    $instanz = new Dbh($host, $user, $pass, $dbname);

    // Errors vorbereiten
    $error = false;
    $errors = array();

    // Prüfen, ob auf Submit geklickt wurde
    if (isset($_POST["submit"])) {

        // Values Prüfen, desinfizieren und speichern
        $titleOfGuide = desinfectSimple($_POST["titleOfGuide"]);

        if ($titleOfGuide == "" ) {
            $error = true;
            array_push($errors, "Du hast keinen Titel eingegeben");
        } else if ( strlen($titleOfGuide) >= 100 ) {
            $error = true;
            array_push($errors, "Du darfst nicht mehr als 100 Zeichen schreiben");
        } else {
            
        }
        $championSelection = desinfectSimple($_POST["championSelection"]);
        if ( strlen($championSelection) <= 1  ) {
            $error = true;
            array_push($errors, "Du hast keinen Champion ausgewählt");
        }
        $role = desinfect($_POST["role"]);
        if ( $role == "" ) {
            $error = true;
            array_push($errors, "Du hast keine Rolle ausgewählt");
        }

        $primaryRune = desinfect($_POST["primaryRune"]);
        $primaryRune1 = desinfect($_POST["primaryRune1"]);
        $primaryRune2 = desinfect($_POST["primaryRune2"]);
        $primaryRune3 = desinfect($_POST["primaryRune3"]);
        $primaryRune4 = desinfect($_POST["primaryRune4"]);
        $secondaryRune = desinfect($_POST["secondaryRune"]);

        $secondaryRune1 = desinfect($_POST["secondaryRune1"]);
        $secondaryRune2 = desinfect($_POST["secondaryRune2"]);
        if ( $secondaryRune1 == $secondaryRune2 ) {
            $error = true;
            array_push($errors, "Du hast zweimal dieselbe Secondary Rune ausgewählt");
        }

        $runeStatMod1 = desinfect($_POST["runeStatMod1"]);
        $runeStatMod2 = desinfect($_POST["runeStatMod2"]);
        $runeStatMod3 = desinfect($_POST["runeStatMod3"]);
        $editor1 = desinfectCKEditor($_POST["editor1"]);

        $summonerSpell1 = "";
        $summonerSpell2 = "";
        // Prüfen, ob Summoner Spells ausgewwählt und mehr als 2 Summoner Spells ausgewählt wurden
        if (isset($_POST["summonerspells"]) && count($_POST["summonerspells"]) == 2) {
            $i = 1;
            foreach($_POST["summonerspells"] as $inhalt){
                if ($i == 1) {
                    $summonerSpell1 = $inhalt;
                    $i++;
                }else {
                    $summonerSpell2 = $inhalt;
                }
            }
        } else {
            array_push($errors, "Es müssen 2 Summoner Spells ausgewählt sein");
            $error = true;
        }
        $summonerSpell1 = desinfect($summonerSpell1);
        $summonerSpell2 = desinfect($summonerSpell2);

        // Prüfen, ob der User überhaupt ein ItemBuild erstellt hat
        if ( isset($_POST['set1']) ) {

            // Titeln der Sets Prüfen
            if ($_POST['set1'] == "") {
                $error = true;
                array_push($errors, "Titel in Set 1 ist leer!");
            } else if (strlen($_POST['set1']) > 50) {
                $error = true;
                array_push($errors, "Titel in Set 1 hat über 50 Zeichen!");
            } else {
                $itemSet1 = desinfect($_POST['set1']);
            }

            if(isset($_POST['Set1item1'])){

                $Set1item1 = desinfect($_POST['Set1item1']);

                if ( isset($_POST['Set1item2']) ) {
                    $Set1item2 = desinfect($_POST['Set1item2']);
                }
                if ( isset($_POST['Set1item3']) ) {
                    $Set1item3 = desinfect($_POST['Set1item3']);
                }
                if ( isset($_POST['Set1item4']) ) {
                    $Set1item4 = desinfect($_POST['Set1item4']);
                }
                if ( isset($_POST['Set1item5']) ) {
                    $Set1item5 = desinfect($_POST['Set1item5']);
                }
                if ( isset($_POST['Set1item6']) ) {
                    $Set1item6 = desinfect($_POST['Set1item6']);
                }
                if ( isset($_POST['Set1item7']) ) {
                    $Set1item7 = desinfect($_POST['Set1item7']);
                }
                if ( isset($_POST['Set1item8']) ) {
                    $Set1item8 = desinfect($_POST['Set1item8']);
                }
                if ( isset($_POST['Set1item9']) ) {
                    $Set1item9 = desinfect($_POST['Set1item9']);
                }
                if ( isset($_POST['Set1item10']) ) {
                    $Set1item10 = desinfect($_POST['Set1item10']);
                }

            } else {
                $error = true;
                array_push($errors, "Es darf keine leeren Sets geben! (Set 1 leer)"); 
            }

            if (isset($_POST['set2'])) {
                if ($_POST['set2'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 2 ist leer!");
                } else if (strlen($_POST['set2']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 2 hat über 50 Zeichen!");
                } else {
                    $itemSet2 = desinfect($_POST['set2']);
                }
                if(isset($_POST['Set2item1'])){
                    $Set2item1 = desinfect($_POST['Set2item1']);
                    if ( isset($_POST['Set2item2']) ) {
                        $Set2item2 = desinfect($_POST['Set2item2']);
                    }
                    if ( isset($_POST['Set2item3']) ) {
                        $Set2item3 = desinfect($_POST['Set2item3']);
                    }
                    if ( isset($_POST['Set2item4']) ) {
                        $Set2item4 = desinfect($_POST['Set2item4']);
                    }
                    if ( isset($_POST['Set2item5']) ) {
                        $Set2item5 = desinfect($_POST['Set2item5']);
                    }
                    if ( isset($_POST['Set2item6']) ) {
                        $Set2item6 = desinfect($_POST['Set2item6']);
                    }
                    if ( isset($_POST['Set2item7']) ) {
                        $Set2item7 = desinfect($_POST['Set2item7']);
                    }
                    if ( isset($_POST['Set2item8']) ) {
                        $Set2item8 = desinfect($_POST['Set2item8']);
                    }
                    if ( isset($_POST['Set2item9']) ) {
                        $Set2item9 = desinfect($_POST['Set2item9']);
                    }
                    if ( isset($_POST['Set2item10']) ) {
                        $Set2item10 = desinfect($_POST['Set2item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 2 leer)"); 
                }
            }

            if (isset($_POST['set3'])) {
                if ($_POST['set3'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 3 ist leer!");
                } else if (strlen($_POST['set3']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 3 hat über 50 Zeichen!");
                } else {
                    $itemSet3 = desinfect($_POST['set3']);
                }
                if(isset($_POST['Set3item1'])){
                    $Set3item1 = desinfect($_POST['Set3item1']);
                    if ( isset($_POST['Set3item2']) ) {
                        $Set3item2 = desinfect($_POST['Set3item2']);
                    }
                    if ( isset($_POST['Set3item3']) ) {
                        $Set3item3 = desinfect($_POST['Set3item3']);
                    }
                    if ( isset($_POST['Set3item4']) ) {
                        $Set3item4 = desinfect($_POST['Set3item4']);
                    }
                    if ( isset($_POST['Set3item5']) ) {
                        $Set3item5 = desinfect($_POST['Set3item5']);
                    }
                    if ( isset($_POST['Set3item6']) ) {
                        $Set3item6 = desinfect($_POST['Set3item6']);
                    }
                    if ( isset($_POST['Set3item7']) ) {
                        $Set3item7 = desinfect($_POST['Set3item7']);
                    }
                    if ( isset($_POST['Set3item8']) ) {
                        $Set3item8 = desinfect($_POST['Set3item8']);
                    }
                    if ( isset($_POST['Set3item9']) ) {
                        $Set3item9 = desinfect($_POST['Set3item9']);
                    }
                    if ( isset($_POST['Set3item10']) ) {
                        $Set3item10 = desinfect($_POST['Set3item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 3 leer)"); 
                }
            }

            if (isset($_POST['set4'])) {
                if ($_POST['set4'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 4 ist leer!");
                } else if (strlen($_POST['set4']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 4 hat über 50 Zeichen!");
                } else {
                    $itemSet4 = desinfect($_POST['set4']);
                }
                if(isset($_POST['Set4item1'])){
                    $Set4item1 = desinfect($_POST['Set4item1']);
                    if ( isset($_POST['Set4item2']) ) {
                        $Set4item2 = desinfect($_POST['Set4item2']);
                    }
                    if ( isset($_POST['Set4item3']) ) {
                        $Set4item3 = desinfect($_POST['Set4item3']);
                    }
                    if ( isset($_POST['Set4item4']) ) {
                        $Set4item4 = desinfect($_POST['Set4item4']);
                    }
                    if ( isset($_POST['Set4item5']) ) {
                        $Set4item5 = desinfect($_POST['Set4item5']);
                    }
                    if ( isset($_POST['Set4item6']) ) {
                        $Set4item6 = desinfect($_POST['Set4item6']);
                    }
                    if ( isset($_POST['Set4item7']) ) {
                        $Set4item7 = desinfect($_POST['Set4item7']);
                    }
                    if ( isset($_POST['Set4item8']) ) {
                        $Set4item8 = desinfect($_POST['Set4item8']);
                    }
                    if ( isset($_POST['Set4item9']) ) {
                        $Set4item9 = desinfect($_POST['Set4item9']);
                    }
                    if ( isset($_POST['Set4item10']) ) {
                        $Set4item10 = desinfect($_POST['Set4item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 4 leer)"); 
                }
            }

            if (isset($_POST['set5'])) {
                if ($_POST['set5'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 5 ist leer!");
                } else if (strlen($_POST['set5']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 5 hat über 50 Zeichen!");
                } else {
                    $itemSet5 = desinfect($_POST['set5']);
                }
                if(isset($_POST['Set5item1'])){
                    $Set5item1 = desinfect($_POST['Set5item1']);
                    if ( isset($_POST['Set5item2']) ) {
                        $Set5item2 = desinfect($_POST['Set5item2']);
                    }
                    if ( isset($_POST['Set5item3']) ) {
                        $Set5item3 = desinfect($_POST['Set5item3']);
                    }
                    if ( isset($_POST['Set5item4']) ) {
                        $Set5item4 = desinfect($_POST['Set5item4']);
                    }
                    if ( isset($_POST['Set5item5']) ) {
                        $Set5item5 = desinfect($_POST['Set5item5']);
                    }
                    if ( isset($_POST['Set5item6']) ) {
                        $Set5item6 = desinfect($_POST['Set5item6']);
                    }
                    if ( isset($_POST['Set5item7']) ) {
                        $Set5item7 = desinfect($_POST['Set5item7']);
                    }
                    if ( isset($_POST['Set5item8']) ) {
                        $Set5item8 = desinfect($_POST['Set5item8']);
                    }
                    if ( isset($_POST['Set5item9']) ) {
                        $Set5item9 = desinfect($_POST['Set5item9']);
                    }
                    if ( isset($_POST['Set5item10']) ) {
                        $Set5item10 = desinfect($_POST['Set5item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 5 leer)"); 
                }
            }

            if (isset($_POST['set6'])) {
                if ($_POST['set6'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 6 ist leer!");
                } else if (strlen($_POST['set6']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 6 hat über 50 Zeichen!");
                } else {
                    $itemSet6 = desinfect($_POST['set6']);
                }
                if(isset($_POST['Set6item1'])){
                    $Set6item1 = desinfect($_POST['Set6item1']);
                    if ( isset($_POST['Set6item2']) ) {
                        $Set6item2 = desinfect($_POST['Set6item2']);
                    }
                    if ( isset($_POST['Set6item3']) ) {
                        $Set6item3 = desinfect($_POST['Set6item3']);
                    }
                    if ( isset($_POST['Set6item4']) ) {
                        $Set6item4 = desinfect($_POST['Set6item4']);
                    }
                    if ( isset($_POST['Set6item5']) ) {
                        $Set6item5 = desinfect($_POST['Set6item5']);
                    }
                    if ( isset($_POST['Set6item6']) ) {
                        $Set6item6 = desinfect($_POST['Set6item6']);
                    }
                    if ( isset($_POST['Set6item7']) ) {
                        $Set6item7 = desinfect($_POST['Set6item7']);
                    }
                    if ( isset($_POST['Set6item8']) ) {
                        $Set6item8 = desinfect($_POST['Set6item8']);
                    }
                    if ( isset($_POST['Set6item9']) ) {
                        $Set6item9 = desinfect($_POST['Set6item9']);
                    }
                    if ( isset($_POST['Set6item10']) ) {
                        $Set6item10 = desinfect($_POST['Set6item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 6 leer)"); 
                }
            }

            if (isset($_POST['set7'])) {
                if ($_POST['set7'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 7 ist leer!");
                } else if (strlen($_POST['set7']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 7 hat über 50 Zeichen!");
                } else {
                    $itemSet7 = desinfect($_POST['set7']);
                }
                if(isset($_POST['Set7item1'])){
                    $Set7item1 = desinfect($_POST['Set7item1']);
                    if ( isset($_POST['Set7item2']) ) {
                        $Set7item2 = desinfect($_POST['Set7item2']);
                    }
                    if ( isset($_POST['Set7item3']) ) {
                        $Set7item3 = desinfect($_POST['Set7item3']);
                    }
                    if ( isset($_POST['Set7item4']) ) {
                        $Set7item4 = desinfect($_POST['Set7item4']);
                    }
                    if ( isset($_POST['Set7item5']) ) {
                        $Set7item5 = desinfect($_POST['Set7item5']);
                    }
                    if ( isset($_POST['Set7item6']) ) {
                        $Set7item6 = desinfect($_POST['Set7item6']);
                    }
                    if ( isset($_POST['Set7item7']) ) {
                        $Set7item7 = desinfect($_POST['Set7item7']);
                    }
                    if ( isset($_POST['Set7item8']) ) {
                        $Set7item8 = desinfect($_POST['Set7item8']);
                    }
                    if ( isset($_POST['Set7item9']) ) {
                        $Set7item9 = desinfect($_POST['Set7item9']);
                    }
                    if ( isset($_POST['Set7item10']) ) {
                        $Set7item10 = desinfect($_POST['Set7item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 7 leer)"); 
                }
            }

            if (isset($_POST['set8'])) {
                if ($_POST['set8'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 8 ist leer!");
                } else if (strlen($_POST['set8']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 8 hat über 50 Zeichen!");
                } else {
                    $itemSet8 = desinfect($_POST['set8']);
                }
                if(isset($_POST['Set8item1'])){
                    $Set8item1 = desinfect($_POST['Set8item1']);
                    if ( isset($_POST['Set8item2']) ) {
                        $Set8item2 = desinfect($_POST['Set8item2']);
                    }
                    if ( isset($_POST['Set8item3']) ) {
                        $Set8item3 = desinfect($_POST['Set8item3']);
                    }
                    if ( isset($_POST['Set8item4']) ) {
                        $Set8item4 = desinfect($_POST['Set8item4']);
                    }
                    if ( isset($_POST['Set8item5']) ) {
                        $Set8item5 = desinfect($_POST['Set8item5']);
                    }
                    if ( isset($_POST['Set8item6']) ) {
                        $Set8item6 = desinfect($_POST['Set8item6']);
                    }
                    if ( isset($_POST['Set8item7']) ) {
                        $Set8item7 = desinfect($_POST['Set8item7']);
                    }
                    if ( isset($_POST['Set8item8']) ) {
                        $Set8item8 = desinfect($_POST['Set8item8']);
                    }
                    if ( isset($_POST['Set8item9']) ) {
                        $Set8item9 = desinfect($_POST['Set8item9']);
                    }
                    if ( isset($_POST['Set8item10']) ) {
                        $Set8item10 = desinfect($_POST['Set8item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 8 leer)"); 
                }
            }

            if (isset($_POST['set9'])) {
                if ($_POST['set9'] == "") {
                    $error = true;
                    array_push($errors, "Titel in Set 9 ist leer!");
                } else if (strlen($_POST['set9']) > 50) {
                    $error = true;
                    array_push($errors, "Titel in Set 9 hat über 50 Zeichen!");
                } else {
                    $itemSet9 = desinfect($_POST['set9']);
                }
                if(isset($_POST['Set9item1'])){
                    $Set9item1 = desinfect($_POST['Set9item1']);
                    if ( isset($_POST['Set9item2']) ) {
                        $Set9item2 = desinfect($_POST['Set9item2']);
                    }
                    if ( isset($_POST['Set9item3']) ) {
                        $Set9item3 = desinfect($_POST['Set9item3']);
                    }
                    if ( isset($_POST['Set9item4']) ) {
                        $Set9item4 = desinfect($_POST['Set9item4']);
                    }
                    if ( isset($_POST['Set9item5']) ) {
                        $Set9item5 = desinfect($_POST['Set9item5']);
                    }
                    if ( isset($_POST['Set9item6']) ) {
                        $Set9item6 = desinfect($_POST['Set9item6']);
                    }
                    if ( isset($_POST['Set9item7']) ) {
                        $Set9item7 = desinfect($_POST['Set9item7']);
                    }
                    if ( isset($_POST['Set9item8']) ) {
                        $Set9item8 = desinfect($_POST['Set9item8']);
                    }
                    if ( isset($_POST['Set9item9']) ) {
                        $Set9item9 = desinfect($_POST['Set9item9']);
                    }
                    if ( isset($_POST['Set9item10']) ) {
                        $Set9item10 = desinfect($_POST['Set9item10']);
                    }
                } else {
                    $error = true;
                    array_push($errors, "Es darf keine leeren Sets geben! (Set 9 leer)"); 
                }
            }

        } else {
            $noItemBuild = true;
        }

        // Value von den Fähigkeiten in zwei teile teilen und separat als Variabeln abspeichern
        $abilityMaxing1array = explode("/", $_POST["abilityMaxing1"]);
        $abilityMaxing2array = explode("/", $_POST["abilityMaxing2"]);
        $abilityMaxing3array = explode("/", $_POST["abilityMaxing3"]);
        $abilityMaxing4array = explode("/", $_POST["abilityMaxing4"]);

        $abilityMaxing1 = "";
        $abilityMaxing1short = "";
        $abilityMaxing2 = "";
        $abilityMaxing2short = "";
        $abilityMaxing3 = "";
        $abilityMaxing3short = "";
        $abilityMaxing4 = "";
        $abilityMaxing4short = "";

        foreach($abilityMaxing1array as $inhalt){
            if (strlen($inhalt) == 1 ) {
                $abilityMaxing1short = desinfect($inhalt);
            } else {
                $abilityMaxing1 = $inhalt;
                $abilityMaxing1 = desinfect($abilityMaxing1);
            }
        }
        foreach($abilityMaxing2array as $inhalt){
            if (strlen($inhalt) == 1 ) {
                $abilityMaxing2short = desinfect($inhalt);
            } else {
                $abilityMaxing2 = $inhalt;
                $abilityMaxing2 = desinfect($abilityMaxing2);
            }
        }
        foreach($abilityMaxing3array as $inhalt){
            if (strlen($inhalt) == 1 ) {
                $abilityMaxing3short = desinfect($inhalt);
            } else {
                $abilityMaxing3 = $inhalt;
                $abilityMaxing3 = desinfect($abilityMaxing3);
            }
        }
        foreach($abilityMaxing4array as $inhalt){
            if (strlen($inhalt) == 1 ) {
                $abilityMaxing4short = desinfect($inhalt);
            } else {
                $abilityMaxing4 = $inhalt;
                $abilityMaxing4 = desinfect($abilityMaxing4);
            }
        }

        if ($abilityMaxing1short == $abilityMaxing2short or $abilityMaxing1short == $abilityMaxing3short or $abilityMaxing1short == $abilityMaxing4short or
        $abilityMaxing2short == $abilityMaxing3short or $abilityMaxing2short == $abilityMaxing4short or $abilityMaxing3short == $abilityMaxing4short) {
            $error = true;
            array_push($errors, "Du hast zwei oder mehrere gleiche Felder bei Ability maxing order ausgewählt");
        }
        
        // Prüft, ob es Fehler bei der überprüfung des Formulares gab
        if($error != true){ // Wenn keine Fehler gefunden worden sind
            echo json_encode(array("Success")); // Gibt ein Array mit dem Inhalt "Success" zurück
        } else { // Wenn Fehler gefunden worden sind
            array_unshift($errors, "Error"); // Fügt dem Array "Errors" den Inhalt "Error" hinzu 
            echo json_encode($errors); // Gibt ein Array mit der Message "Error" und alle Fehlermeldungen zurück
        }

    };

?>