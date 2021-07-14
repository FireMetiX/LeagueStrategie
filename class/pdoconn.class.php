<?php

class Dbh extends PDO {

    // ###################################
    // DATENBANK VERBINDUNG
    // ###################################

    public function __construct($host, $user, $pass, $dbname){

        // DSN verbindung schreiben
        $dsn = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8';

        // Options Variabeln vorbereiten
        $db_options = array(
            // PDO Errors kriegen
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Assoc Arrays herbekommen
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        // verbindung herstellen mit try/catch
        try {
            // Konstruktor der PDO-Klasse (Superklasse) aufrufen
			parent::__construct($dsn, $user, $pass, $db_options);
        } catch (PDOException $e) {
            // Gibt aus, was der fehler war
            die("Verbindung zur Datenbank fehlgeschlagen: ".$e->getMessage());
        }
    }

    // ###################################
    // ALLE QUERY METHODEN
    // ###################################

    // Login methode

    public function login($username, $passwort, $errorcheck){

        $query = "SELECT * FROM `users` WHERE `username`=?";
        $stmt = $this->prepare($query);
        $stmt -> bindParam(1, $username, PDO::PARAM_STR);
        $stmt ->execute();
        $numRows = $stmt->rowCount();
        // return $count;

        if ($errorcheck == 0) {

            if ( $numRows == 1 ) {
                $row = $stmt->fetch();
                if(password_verify($passwort,$row['passwortHash'])){
                    // Infos an Session geben
                    $_SESSION['isLoggedin'] = true;
                    $_SESSION['username'] = $row["username"];
                    $_SESSION['userID'] = $row['ID'];
                    if ($row["roleID"] == 1) {
                        $_SESSION["role"] = "admin";
                    } else {
                        $_SESSION["role"] = "user";
                    }
                    header("Location: ../index.php");
    
                } else {
                    echo "Falsche UserDaten";

                }
            } else {
                echo "No User found";

            }

        } else {

            if ( $numRows == 1 ) {
                $row = $stmt->fetch();
                if(password_verify($passwort,$row['passwortHash'])){
                    // Infos an Session geben
                    $_SESSION['isLoggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['userID'] = $row['ID'];
                    if ($row["roleID"] == 1) {
                        $_SESSION["role"] = "admin";
                    } else {
                        $_SESSION["role"] = "user";
                    }
    
                    return json_encode(array("success", $row['username'], $row["roleID"]));
    
                } else {

                    return json_encode(array("error", "Falsche Userdaten eingegeben"));

                }
            } else {

                return json_encode(array("error", "Benutzer existiert nicht"));

            }

        }

    }

    // Register methode

    public function register($nachname, $vorname, $username, $hashPassword, $email, $errorcheck){

        // Variabeln vorbereiten
        $error = false;
        $errors = array();

        // Query zum überprüfen der Userdaten vorbereiten
        $query = "SELECT * FROM `users` WHERE `email`=?";
        $stmt = $this->prepare($query);
        $stmt -> bindParam(1, $email);
        $stmt ->execute();
        $numRows = $stmt->rowCount();

        if ($errorcheck == 1) {

            // Formular Validieren
            if ($nachname == "") {
                array_push($errors, "Kein Nachname gesetzt");
                $error = true;
            } else if ( strlen($nachname) > 50 ) {
                array_push($errors, "Nachname hat mehr als 50 Zeichen");
                $error = true;
            }
            if ($vorname == "") {
                array_push($errors, "Kein Vorname gesetzt");
                $error = true;
            } else if ( strlen($vorname) > 50 ) {
                array_push($errors, "Vorname hat mehr als 50 Zeichen");
                $error = true;
            }
            if ($username == "") {
                array_push($errors, "Kein Username gesetzt");
                $error = true;
            } else if ( strlen($username) > 50 ) {
                array_push($errors, "Username hat mehr als 50 Zeichen");
                $error = true;
            }

            if($numRows >= 1){
                $row = $stmt->fetch();
                if ( $email == $row["email"] ) {
                    array_push($errors, "Diese Email existiert schon");
                    $error = true;
                }
            } else {
                if ($email == "") {
                    array_push($errors, "Keine Email gesetzt");
                    $error = true;
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors, "Bitte eine echte Email eingeben");
                    $error = true;
                }
            }
            
            // Bei keinem Fehler soll es die Userdaten in die Datenbank einfügen
            if ($error == false) {

                    return json_encode(array("success"));

            } else {
                
                array_unshift($errors, "error");
                return json_encode($errors);

            }
            
        } else {

            // Formular Validieren
            if ($nachname == "") {
                array_push($errors, "Kein Nachname gesetzt");
                $error = true;
            } else if ( strlen($nachname) > 50 ) {
                array_push($errors, "Nachname hat mehr als 50 Zeichen");
                $error = true;
            }
            if ($vorname == "") {
                array_push($errors, "Kein Vorname gesetzt");
                $error = true;
            } else if ( strlen($vorname) > 50 ) {
                array_push($errors, "Vorname hat mehr als 50 Zeichen");
                $error = true;
            }
            if ($username == "") {
                array_push($errors, "Kein Username gesetzt");
                $error = true;
            } else if ( strlen($username) > 50 ) {
                array_push($errors, "Username hat mehr als 50 Zeichen");
                $error = true;
            }

            if($numRows == 1){
                if ( $email == $row["email"] ) {
                    array_push($errors, "Diese Email existiert schon");
                    $error = true;
                }
            } else {
                if ($email == "") {
                    array_push($errors, "Keine Email gesetzt");
                    $error = true;
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($errors, "Bitte eine echte Email eingeben");
                    $error = true;
                }
            }
            
            // Bei keinem Fehler soll es die Userdaten in die Datenbank einfügen
            if ($error == false) {

                // Query zum hinzufügen der Daten in der Datenbank vorbereiten
                $queryInsert = "INSERT INTO `users` (`nachname`,`vorname`,`username`,`passwortHash`,`email`,`roleID`) 
                VALUES (?, ?, ?, ?, ?, 2)";
                $stmt = $this->prepare($queryInsert);
                $stmt -> bindParam(1, $nachname, PDO::PARAM_STR);
                $stmt -> bindParam(2, $vorname, PDO::PARAM_STR);
                $stmt -> bindParam(3, $username, PDO::PARAM_STR);
                $stmt -> bindParam(4, $hashPassword, PDO::PARAM_STR);
                $stmt -> bindParam(5, $email, PDO::PARAM_STR);

                if($stmt ->execute()){
                    header("Location: login.php");
                } else {
                    die("Ein Fehler ist aufgetreten");
                }

            } else {

                die("Ein Fehler ist aufgetreten");

            }

        }
    }

    // Show guides methode

    public function showGuides($filter, $role, $champion, $currentPage, $guidesPerPage){ // filter 0 = no filter, 1 = just champion, 2 = just role, 3 = role and champion

        // Wenn keine Filter gesetzt worden sind
        if( $filter == 0 ){

            // Query für die Anzahl Pages
            $queryAll = "SELECT * FROM `guides`";
            $stmtAll = $this->prepare($queryAll);
            $stmtAll->execute();
            $numRowsAll = $stmtAll->rowCount();

            // Query vorbereiten
            $query = "SELECT * FROM `guides` ORDER BY `ID` DESC LIMIT $currentPage,$guidesPerPage";
            $stmt = $this->prepare($query);
            $stmt ->execute();
            $numRows = $stmt->rowCount();
    
            // Wenn Guides vorhanden sind
            if ( $numRows > 0 ) {

                //Maximale anzahl der Pages bestimmen
                $maxPages = $numRowsAll / $guidesPerPage;
                // Zahl gerade formatieren
                if (is_float($maxPages)){
                    $maxPages = ceil($maxPages);
                }
                //Gibt die werte als Array zurück
                return array($maxPages, $stmt->fetchAll());

            } else { // Wenn keine Guides gefunden worden sind
                // FEHLER
            }

        } else if( $filter == 1 ) { // Wenn ein Champion filter gesetzt worden ist

            // Query für die Anzahl Pages
            $queryAll = "SELECT * FROM `guides` WHERE `champion`='$champion'";
            $stmtAll = $this->prepare($queryAll);
            $stmtAll ->execute();
            $numRowsAll = $stmtAll->rowCount();

            // Query vorbereiten
            $query = "SELECT * FROM `guides` WHERE `champion`='$champion' ORDER BY `ID` DESC LIMIT $currentPage,$guidesPerPage";
            $stmt = $this->prepare($query);
            $stmt ->execute();
            $numRows = $stmt->rowCount();

            if( $numRows > 0 ){

                //Maximale anzahl der Pages bestimmen
                $maxPages = $numRowsAll / $guidesPerPage;
                // Zahl gerade formatieren
                if (is_float($maxPages)){
                    $maxPages = ceil($maxPages);
                }
                //Gibt die werte als Array zurück
                return array($maxPages, $stmt->fetchAll());

            } else {
                return array(0);
            }

        } else if( $filter == 2 ) { // Wenn ein Role filter gesetzt worden ist

            // Query für die Anzahl Pages
            $queryAll = "SELECT * FROM `guides` WHERE `role`='$role'";
            $stmtAll = $this->prepare($queryAll);
            $stmtAll ->execute();
            $numRowsAll = $stmtAll->rowCount();

            // Query vorbereiten
            $query = "SELECT * FROM `guides` WHERE `role`='$role' ORDER BY `ID` DESC LIMIT $currentPage,$guidesPerPage";
            $stmt = $this->prepare($query);
            $stmt ->execute();
            $numRows = $stmt->rowCount();

            if( $numRows > 0 ){

                //Maximale anzahl der Pages bestimmen
                $maxPages = $numRowsAll / $guidesPerPage;
                // Zahl gerade formatieren
                if (is_float($maxPages)){
                    $maxPages = ceil($maxPages);
                }
                //Gibt die werte als Array zurück
                return array($maxPages, $stmt->fetchAll());

            } else {
                // FEHLER
            }

        } else if( $filter == 3 ) { // Wenn ein Champion und Role filter gesetzt worden sind

            // Query für die Anzahl Pages
            $queryAll = "SELECT * FROM `guides` WHERE `role`='$role' and `champion`='$champion'";
            $stmtAll = $this->prepare($queryAll);
            $stmtAll ->execute();
            $numRowsAll = $stmtAll->rowCount();

            // Query vorbereiten
            $query = "SELECT * FROM `guides` WHERE `role`='$role' and `champion`='$champion' ORDER BY `ID` DESC LIMIT $currentPage,$guidesPerPage";
            $stmt = $this->prepare($query);
            $stmt ->execute();
            $numRows = $stmt->rowCount();

            if( $numRows > 0 ){

                //Maximale anzahl der Pages bestimmen
                $maxPages = $numRowsAll / $guidesPerPage;
                // Zahl gerade formatieren
                if (is_float($maxPages)){
                    $maxPages = ceil($maxPages);
                }
                //Gibt die werte als Array zurück
                return array($maxPages, $stmt->fetchAll());

            } else {
                // FEHLER
            }

        } else {
            // FEHLER AUFGETRETEN
        }

    }

    // checkSelected methode 

    public function checkSelected($guideID){ // Prüft in einem Fetch im deleteGuide.js ob der User berechtigt ist, diese funktion auszuführen 

        $query = "SELECT * FROM `guides` WHERE `ID`='$guideID'";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $numRows = $stmt->rowCount();

        if( $numRows > 0 ){
            $row = $stmt->fetch();
            return $row['userID'];
        } else {
            die("Ein Fehler ist aufgetreten!");
        }

    }

    // deleteSelected methode

    public function deleteSelected($guideID){ // Löscht den ausgewählten Guide und dessen ItemBuild

        $query = "DELETE FROM `guides` WHERE `ID`='$guideID'";
        $stmt = $this->prepare($query);
        $stmt->execute();

        $queryItemBuild = "DELETE FROM `itembuilds` WHERE `guideID`='$guideID'";
        $stmtItemBuild = $this->prepare($queryItemBuild);
        $stmtItemBuild->execute();

    }

    // showGuide methode

    public function showGuide($guideID){

        // Query vorberiten
        $query = "SELECT * FROM `guides` WHERE `ID`='$guideID'";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $numRows = $stmt->rowCount();

        if ($numRows == 1) {
            return $stmt->fetch(); // gibt die gefetchten Daten zurück
        } else {
            die("Kein Guide gefunden!");
        }

    }

    // showBuild methode

    public function showBuild($guideID){

        // Query vorberiten
        $query = "SELECT * FROM `itembuilds` WHERE `guideID`='$guideID'";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $numRows = $stmt->rowCount();

        if ($numRows == 1) {
            return $stmt->fetch(); // gibt die gefetchten Daten zurück
        } else {
            return "NoBuild"; // Wenn kein Build gefunden wurde wird ein String geschickt.
        }
    }

    // showNewestGuides methode

    public function showNewestGuides(){ // Zeigt im AdminDashboard die 3 neusten Guides an
        $query = "SELECT * FROM `guides` ORDER BY `ID` DESC LIMIT 0,3";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $numRows = $stmt->rowCount();

        if( $numRows >= 1 ){
            return $stmt->fetchAll();
        } else {
            return "NoGuides";
        }
    }

    // showNewestUsers methode

    public function showNewestUsers(){ // Zeigt im AdminDashboard die 3 neusten User an
        $query = "SELECT * FROM `users` ORDER BY `ID` DESC LIMIT 0,3";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $numRows = $stmt->rowCount();

        if( $numRows >= 1 ){
            return $stmt->fetchAll();
        } else {
            return "NoUsers";
        }
    }

    // deleteUserAndGuides methode

    public function deleteUserAndGuides($userID){ // Löscht den ausgewählten User sammt alle von Ihm erstellten Guides

        $queryUser = "DELETE FROM `users` WHERE `ID`='$userID'";
        $stmtUser = $this->prepare($queryUser);
        $stmtUser->execute();

        $queryGuides = "DELETE FROM `guides` WHERE `userID`='$userID'";
        $stmtGuides = $this->prepare($queryGuides);
        $stmtGuides->execute();

    }

    // checkSelectedUser methode

    public function checkSelectedUser($userID){

        $queryUser = "SELECT * FROM `users` WHERE `ID`='$userID'";
        $stmtUser = $this->prepare($queryUser);
        $stmtUser->execute();
        $numRows = $stmtUser->rowCount();

        if( $numRows == 1 ){
            $row = $stmt->fetch();
            return $row['ID'];
        } else {
            die("Ein Fehler ist aufgetreten!");
        }
    }

    // insertGuide methode

    public function insertGuide($userID, $username, $titleOfGuide, $championSelection, $role, $primaryRune, $primaryRune1, 
    $primaryRune2, $primaryRune3, $primaryRune4, $secondaryRune, $secondaryRune1, $secondaryRune2, $runeStatMod1, 
    $runeStatMod2, $runeStatMod3, $summonerSpell1, $summonerSpell2, $abilityMaxing1short, $abilityMaxing1, $abilityMaxing2short, 
    $abilityMaxing2, $abilityMaxing3short, $abilityMaxing3, $abilityMaxing4short, $abilityMaxing4, $theGuide) {

        $queryInsert = "INSERT INTO `guides`(`userID`, `username`, `guideTitle`, `champion`, `role`, `primaryrune`, `primaryrune1`, 
        `primaryrune2`, `primaryrune3`, `primaryrune4`, `secondaryrune`, `secondaryrune1`, `secondaryrune2`, `runeStatMod1`, 
        `runeStatMod2`, `runeStatMod3`, `summonerSpell1`, `summonerSpell2`, `abilityMaxing1short`, `abilityMaxing1`, 
        `abilityMaxing2short`, `abilityMaxing2`, `abilityMaxing3short`, `abilityMaxing3`, `abilityMaxing4short`, `abilityMaxing4`, `theGuide`) 
        VALUES ($userID, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->prepare($queryInsert);
        $stmt -> bindParam(1, $username, PDO::PARAM_STR);
        $stmt -> bindParam(2, $titleOfGuide, PDO::PARAM_STR);
        $stmt -> bindParam(3, $championSelection, PDO::PARAM_STR);
        $stmt -> bindParam(4, $role, PDO::PARAM_STR);
        $stmt -> bindParam(5, $primaryRune, PDO::PARAM_STR);
        $stmt -> bindParam(6, $primaryRune1, PDO::PARAM_STR);
        $stmt -> bindParam(7, $primaryRune2, PDO::PARAM_STR);
        $stmt -> bindParam(8, $primaryRune3, PDO::PARAM_STR);
        $stmt -> bindParam(9, $primaryRune4, PDO::PARAM_STR);
        $stmt -> bindParam(10, $secondaryRune, PDO::PARAM_STR);
        $stmt -> bindParam(11, $secondaryRune1, PDO::PARAM_STR);
        $stmt -> bindParam(12, $secondaryRune2, PDO::PARAM_STR);
        $stmt -> bindParam(13, $runeStatMod1, PDO::PARAM_STR);
        $stmt -> bindParam(14, $runeStatMod2, PDO::PARAM_STR);
        $stmt -> bindParam(15, $runeStatMod3, PDO::PARAM_STR);
        $stmt -> bindParam(16, $summonerSpell1, PDO::PARAM_STR);
        $stmt -> bindParam(17, $summonerSpell2, PDO::PARAM_STR);
        $stmt -> bindParam(18, $abilityMaxing1short, PDO::PARAM_STR);
        $stmt -> bindParam(19, $abilityMaxing1, PDO::PARAM_STR);
        $stmt -> bindParam(20, $abilityMaxing2short, PDO::PARAM_STR);
        $stmt -> bindParam(21, $abilityMaxing2, PDO::PARAM_STR);
        $stmt -> bindParam(22, $abilityMaxing3short, PDO::PARAM_STR);
        $stmt -> bindParam(23, $abilityMaxing3, PDO::PARAM_STR);
        $stmt -> bindParam(24, $abilityMaxing4short, PDO::PARAM_STR);
        $stmt -> bindParam(25, $abilityMaxing4, PDO::PARAM_STR);
        $stmt -> bindParam(26, $theGuide, PDO::PARAM_STR);

        if($stmt ->execute()){
            
        } else {
            die("Ein Fehler ist aufgetreten");
        }
    }

    // getLatestGuideID methode

    public function getLatestGuideID() {
        $query = "SELECT * FROM `guides` ORDER BY ID DESC LIMIT 1";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['ID'];
    }

    // insertItemBuild methode

    public function insertItemBuild($guideID, $itemSet1, $Set1item1, $Set1item2, $Set1item3, $Set1item4, $Set1item5, $Set1item6, $Set1item7, $Set1item8, $Set1item9, $Set1item10, 
        $itemSet2, $Set2item1, $Set2item2, $Set2item3, $Set2item4, $Set2item5, $Set2item6, $Set2item7, $Set2item8, $Set2item9, $Set2item10,
        $itemSet3, $Set3item1, $Set3item2, $Set3item3, $Set3item4, $Set3item5, $Set3item6, $Set3item7, $Set3item8, $Set3item9, $Set3item10,
        $itemSet4, $Set4item1, $Set4item2, $Set4item3, $Set4item4, $Set4item5, $Set4item6, $Set4item7, $Set4item8, $Set4item9, $Set4item10,
        $itemSet5, $Set5item1, $Set5item2, $Set5item3, $Set5item4, $Set5item5, $Set5item6, $Set5item7, $Set5item8, $Set5item9, $Set5item10,
        $itemSet6, $Set6item1, $Set6item2, $Set6item3, $Set6item4, $Set6item5, $Set6item6, $Set6item7, $Set6item8, $Set6item9, $Set6item10,
        $itemSet7, $Set7item1, $Set7item2, $Set7item3, $Set7item4, $Set7item5, $Set7item6, $Set7item7, $Set7item8, $Set7item9, $Set7item10,
        $itemSet8, $Set8item1, $Set8item2, $Set8item3, $Set8item4, $Set8item5, $Set8item6, $Set8item7, $Set8item8, $Set8item9, $Set8item10,
        $itemSet9, $Set9item1, $Set9item2, $Set9item3, $Set9item4, $Set9item5, $Set9item6, $Set9item7, $Set9item8, $Set9item9, $Set9item10) {

        $query = "INSERT INTO `itembuilds`(`guideID`, `set1`, `Set1item1`, `Set1item2`, `Set1item3`, `Set1item4`, 
        `Set1item5`, `Set1item6`, `Set1item7`, `Set1item8`, `Set1item9`, `Set1item10`, `set2`, `Set2item1`, `Set2item2`, `Set2item3`, 
        `Set2item4`, `Set2item5`, `Set2item6`, `Set2item7`, `Set2item8`, `Set2item9`, `Set2item10`, `set3`, `Set3item1`, `Set3item2`, 
        `Set3item3`, `Set3item4`, `Set3item5`, `Set3item6`, `Set3item7`, `Set3item8`, `Set3item9`, `Set3item10`, `set4`, `Set4item1`, 
        `Set4item2`, `Set4item3`, `Set4item4`, `Set4item5`, `Set4item6`, `Set4item7`, `Set4item8`, `Set4item9`, `Set4item10`, `set5`, 
        `Set5item1`, `Set5item2`, `Set5item3`, `Set5item4`, `Set5item5`, `Set5item6`, `Set5item7`, `Set5item8`, `Set5item9`, `Set5item10`, 
        `set6`, `Set6item1`, `Set6item2`, `Set6item3`, `Set6item4`, `Set6item5`, `Set6item6`, `Set6item7`, `Set6item8`, `Set6item9`, 
        `Set6item10`, `set7`, `Set7item1`, `Set7item2`, `Set7item3`, `Set7item4`, `Set7item5`, `Set7item6`, `Set7item7`, `Set7item8`, 
        `Set7item9`, `Set7item10`, `set8`, `Set8item1`, `Set8item2`, `Set8item3`, `Set8item4`, `Set8item5`, `Set8item6`, `Set8item7`, 
        `Set8item8`, `Set8item9`, `Set8item10`, `set9`, `Set9item1`, `Set9item2`, `Set9item3`, `Set9item4`, `Set9item5`, `Set9item6`, 
        `Set9item7`, `Set9item8`, `Set9item9`, `Set9item10`) 
        VALUES ($guideID,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
        $stmt = $this->prepare($query);

        $stmt -> bindParam(1, $itemSet1, PDO::PARAM_STR);
        $stmt -> bindParam(2, $Set1item1, PDO::PARAM_STR);
        $stmt -> bindParam(3, $Set1item2, PDO::PARAM_STR);
        $stmt -> bindParam(4, $Set1item3, PDO::PARAM_STR);
        $stmt -> bindParam(5, $Set1item4, PDO::PARAM_STR);
        $stmt -> bindParam(6, $Set1item5, PDO::PARAM_STR);
        $stmt -> bindParam(7, $Set1item6, PDO::PARAM_STR);
        $stmt -> bindParam(8, $Set1item7, PDO::PARAM_STR);
        $stmt -> bindParam(9, $Set1item8, PDO::PARAM_STR);
        $stmt -> bindParam(10, $Set1item9, PDO::PARAM_STR);
        $stmt -> bindParam(11, $Set1item10, PDO::PARAM_STR);
        $stmt -> bindParam(12, $itemSet2, PDO::PARAM_STR);
        $stmt -> bindParam(13, $Set2item1, PDO::PARAM_STR);
        $stmt -> bindParam(14, $Set2item2, PDO::PARAM_STR);
        $stmt -> bindParam(15, $Set2item3, PDO::PARAM_STR);
        $stmt -> bindParam(16, $Set2item4, PDO::PARAM_STR);
        $stmt -> bindParam(17, $Set2item5, PDO::PARAM_STR);
        $stmt -> bindParam(18, $Set2item6, PDO::PARAM_STR);
        $stmt -> bindParam(19, $Set2item7, PDO::PARAM_STR);
        $stmt -> bindParam(20, $Set2item8, PDO::PARAM_STR);
        $stmt -> bindParam(21, $Set2item9, PDO::PARAM_STR);
        $stmt -> bindParam(22, $Set2item10, PDO::PARAM_STR);
        $stmt -> bindParam(23, $itemSet3, PDO::PARAM_STR);
        $stmt -> bindParam(24, $Set3item1, PDO::PARAM_STR);
        $stmt -> bindParam(25, $Set3item2, PDO::PARAM_STR);
        $stmt -> bindParam(26, $Set3item3, PDO::PARAM_STR);
        $stmt -> bindParam(27, $Set3item4, PDO::PARAM_STR);
        $stmt -> bindParam(28, $Set3item5, PDO::PARAM_STR);
        $stmt -> bindParam(29, $Set3item6, PDO::PARAM_STR);
        $stmt -> bindParam(30, $Set3item7, PDO::PARAM_STR);
        $stmt -> bindParam(31, $Set3item8, PDO::PARAM_STR);
        $stmt -> bindParam(32, $Set3item9, PDO::PARAM_STR);
        $stmt -> bindParam(33, $Set3item10, PDO::PARAM_STR);
        $stmt -> bindParam(34, $itemSet4, PDO::PARAM_STR);
        $stmt -> bindParam(35, $Set4item1, PDO::PARAM_STR);
        $stmt -> bindParam(36, $Set4item2, PDO::PARAM_STR);
        $stmt -> bindParam(37, $Set4item3, PDO::PARAM_STR);
        $stmt -> bindParam(38, $Set4item4, PDO::PARAM_STR);
        $stmt -> bindParam(39, $Set4item5, PDO::PARAM_STR);
        $stmt -> bindParam(40, $Set4item6, PDO::PARAM_STR);
        $stmt -> bindParam(41, $Set4item7, PDO::PARAM_STR);
        $stmt -> bindParam(42, $Set4item8, PDO::PARAM_STR);
        $stmt -> bindParam(43, $Set4item9, PDO::PARAM_STR);
        $stmt -> bindParam(44, $Set4item10, PDO::PARAM_STR);
        $stmt -> bindParam(45, $itemSet5, PDO::PARAM_STR);
        $stmt -> bindParam(46, $Set5item1, PDO::PARAM_STR);
        $stmt -> bindParam(47, $Set5item2, PDO::PARAM_STR);
        $stmt -> bindParam(48, $Set5item3, PDO::PARAM_STR);
        $stmt -> bindParam(49, $Set5item4, PDO::PARAM_STR);
        $stmt -> bindParam(50, $Set5item5, PDO::PARAM_STR);
        $stmt -> bindParam(51, $Set5item6, PDO::PARAM_STR);
        $stmt -> bindParam(52, $Set5item7, PDO::PARAM_STR);
        $stmt -> bindParam(53, $Set5item8, PDO::PARAM_STR);
        $stmt -> bindParam(54, $Set5item9, PDO::PARAM_STR);
        $stmt -> bindParam(55, $Set5item10, PDO::PARAM_STR);
        $stmt -> bindParam(56, $itemSet6, PDO::PARAM_STR);
        $stmt -> bindParam(57, $Set6item1, PDO::PARAM_STR);
        $stmt -> bindParam(58, $Set6item2, PDO::PARAM_STR);
        $stmt -> bindParam(59, $Set6item3, PDO::PARAM_STR);
        $stmt -> bindParam(60, $Set6item4, PDO::PARAM_STR);
        $stmt -> bindParam(61, $Set6item5, PDO::PARAM_STR);
        $stmt -> bindParam(62, $Set6item6, PDO::PARAM_STR);
        $stmt -> bindParam(63, $Set6item7, PDO::PARAM_STR);
        $stmt -> bindParam(64, $Set6item8, PDO::PARAM_STR);
        $stmt -> bindParam(65, $Set6item9, PDO::PARAM_STR);
        $stmt -> bindParam(66, $Set6item10, PDO::PARAM_STR);
        $stmt -> bindParam(67, $itemSet7, PDO::PARAM_STR);
        $stmt -> bindParam(68, $Set7item1, PDO::PARAM_STR);
        $stmt -> bindParam(69, $Set7item2, PDO::PARAM_STR);
        $stmt -> bindParam(70, $Set7item3, PDO::PARAM_STR);
        $stmt -> bindParam(71, $Set7item4, PDO::PARAM_STR);
        $stmt -> bindParam(72, $Set7item5, PDO::PARAM_STR);
        $stmt -> bindParam(73, $Set7item6, PDO::PARAM_STR);
        $stmt -> bindParam(74, $Set7item7, PDO::PARAM_STR);
        $stmt -> bindParam(75, $Set7item8, PDO::PARAM_STR);
        $stmt -> bindParam(76, $Set7item9, PDO::PARAM_STR);
        $stmt -> bindParam(77, $Set7item10, PDO::PARAM_STR);
        $stmt -> bindParam(78, $itemSet8, PDO::PARAM_STR);
        $stmt -> bindParam(79, $Set8item1, PDO::PARAM_STR);
        $stmt -> bindParam(80, $Set8item2, PDO::PARAM_STR);
        $stmt -> bindParam(81, $Set8item3, PDO::PARAM_STR);
        $stmt -> bindParam(82, $Set8item4, PDO::PARAM_STR);
        $stmt -> bindParam(83, $Set8item5, PDO::PARAM_STR);
        $stmt -> bindParam(84, $Set8item6, PDO::PARAM_STR);
        $stmt -> bindParam(85, $Set8item7, PDO::PARAM_STR);
        $stmt -> bindParam(86, $Set8item8, PDO::PARAM_STR);
        $stmt -> bindParam(87, $Set8item9, PDO::PARAM_STR);
        $stmt -> bindParam(88, $Set8item10, PDO::PARAM_STR);
        $stmt -> bindParam(89, $itemSet9, PDO::PARAM_STR);
        $stmt -> bindParam(90, $Set9item1, PDO::PARAM_STR);
        $stmt -> bindParam(91, $Set9item2, PDO::PARAM_STR);
        $stmt -> bindParam(92, $Set9item3, PDO::PARAM_STR);
        $stmt -> bindParam(93, $Set9item4, PDO::PARAM_STR);
        $stmt -> bindParam(94, $Set9item5, PDO::PARAM_STR);
        $stmt -> bindParam(95, $Set9item6, PDO::PARAM_STR);
        $stmt -> bindParam(96, $Set9item7, PDO::PARAM_STR);
        $stmt -> bindParam(97, $Set9item8, PDO::PARAM_STR);
        $stmt -> bindParam(98, $Set9item9, PDO::PARAM_STR);
        $stmt -> bindParam(99, $Set9item10, PDO::PARAM_STR);

        if($stmt ->execute()){
            
        } else {
            die("Ein Fehler beim einfügen des Item Builds ist aufgetreten");
        }

    }

    // editGuide methode

    public function editGuide($guideID, $titleOfGuide, $championSelection, $role, $primaryRune, $primaryRune1, 
    $primaryRune2, $primaryRune3, $primaryRune4, $secondaryRune, $secondaryRune1, $secondaryRune2, $runeStatMod1, 
    $runeStatMod2, $runeStatMod3, $summonerSpell1, $summonerSpell2, $abilityMaxing1short, $abilityMaxing1, $abilityMaxing2short, 
    $abilityMaxing2, $abilityMaxing3short, $abilityMaxing3, $abilityMaxing4short, $abilityMaxing4, $theGuide){

        $query = "UPDATE `guides` SET `guideTitle`=?,`champion`=?,`role`=?,`primaryrune`=?,
        `primaryrune1`=?,`primaryrune2`=?,`primaryrune3`=?,`primaryrune4`=?,`secondaryrune`=?,`secondaryrune1`=?,
        `secondaryrune2`=?,`runeStatMod1`=?,`runeStatMod2`=?,`runeStatMod3`=?,`summonerSpell1`=?,`summonerSpell2`=?,
        `abilityMaxing1short`=?,`abilityMaxing1`=?,`abilityMaxing2short`=?,`abilityMaxing2`=?,`abilityMaxing3short`=?,
        `abilityMaxing3`=?,`abilityMaxing4short`=?,`abilityMaxing4`=?,`theGuide`=? WHERE `ID`='$guideID'";

        $stmt = $this->prepare($query);
        $stmt -> bindParam(1, $titleOfGuide, PDO::PARAM_STR);
        $stmt -> bindParam(2, $championSelection, PDO::PARAM_STR);
        $stmt -> bindParam(3, $role, PDO::PARAM_STR);
        $stmt -> bindParam(4, $primaryRune, PDO::PARAM_STR);
        $stmt -> bindParam(5, $primaryRune1, PDO::PARAM_STR);
        $stmt -> bindParam(6, $primaryRune2, PDO::PARAM_STR);
        $stmt -> bindParam(7, $primaryRune3, PDO::PARAM_STR);
        $stmt -> bindParam(8, $primaryRune4, PDO::PARAM_STR);
        $stmt -> bindParam(9, $secondaryRune, PDO::PARAM_STR);
        $stmt -> bindParam(10, $secondaryRune1, PDO::PARAM_STR);
        $stmt -> bindParam(11, $secondaryRune2, PDO::PARAM_STR);
        $stmt -> bindParam(12, $runeStatMod1, PDO::PARAM_STR);
        $stmt -> bindParam(13, $runeStatMod2, PDO::PARAM_STR);
        $stmt -> bindParam(14, $runeStatMod3, PDO::PARAM_STR);
        $stmt -> bindParam(15, $summonerSpell1, PDO::PARAM_STR);
        $stmt -> bindParam(16, $summonerSpell2, PDO::PARAM_STR);
        $stmt -> bindParam(17, $abilityMaxing1short, PDO::PARAM_STR);
        $stmt -> bindParam(18, $abilityMaxing1, PDO::PARAM_STR);
        $stmt -> bindParam(19, $abilityMaxing2short, PDO::PARAM_STR);
        $stmt -> bindParam(20, $abilityMaxing2, PDO::PARAM_STR);
        $stmt -> bindParam(21, $abilityMaxing3short, PDO::PARAM_STR);
        $stmt -> bindParam(22, $abilityMaxing3, PDO::PARAM_STR);
        $stmt -> bindParam(23, $abilityMaxing4short, PDO::PARAM_STR);
        $stmt -> bindParam(24, $abilityMaxing4, PDO::PARAM_STR);
        $stmt -> bindParam(25, $theGuide, PDO::PARAM_STR);

        if($stmt ->execute()){
            
        } else {
            die("Ein Fehler ist aufgetreten");
        }

    }

    // checkIfItemBuild methode

    public function checkIfItemBuild($guideID) {
        $query = "SELECT * FROM `itembuilds` WHERE `guideID`='$guideID'";
        $stmt = $this->prepare($query);
        $stmt->execute();
        $numRows = $stmt->rowCount();

        if ($numRows == 1) {
            return true;
        } else {
            return false;
        }
    }

    // editItemBuild methode

    public function editItemBuild($guideID, $itemSet1, $Set1item1, $Set1item2, $Set1item3, $Set1item4, $Set1item5, $Set1item6, $Set1item7, $Set1item8, $Set1item9, $Set1item10, 
    $itemSet2, $Set2item1, $Set2item2, $Set2item3, $Set2item4, $Set2item5, $Set2item6, $Set2item7, $Set2item8, $Set2item9, $Set2item10,
    $itemSet3, $Set3item1, $Set3item2, $Set3item3, $Set3item4, $Set3item5, $Set3item6, $Set3item7, $Set3item8, $Set3item9, $Set3item10,
    $itemSet4, $Set4item1, $Set4item2, $Set4item3, $Set4item4, $Set4item5, $Set4item6, $Set4item7, $Set4item8, $Set4item9, $Set4item10,
    $itemSet5, $Set5item1, $Set5item2, $Set5item3, $Set5item4, $Set5item5, $Set5item6, $Set5item7, $Set5item8, $Set5item9, $Set5item10,
    $itemSet6, $Set6item1, $Set6item2, $Set6item3, $Set6item4, $Set6item5, $Set6item6, $Set6item7, $Set6item8, $Set6item9, $Set6item10,
    $itemSet7, $Set7item1, $Set7item2, $Set7item3, $Set7item4, $Set7item5, $Set7item6, $Set7item7, $Set7item8, $Set7item9, $Set7item10,
    $itemSet8, $Set8item1, $Set8item2, $Set8item3, $Set8item4, $Set8item5, $Set8item6, $Set8item7, $Set8item8, $Set8item9, $Set8item10,
    $itemSet9, $Set9item1, $Set9item2, $Set9item3, $Set9item4, $Set9item5, $Set9item6, $Set9item7, $Set9item8, $Set9item9, $Set9item10){

        $query = "UPDATE `itembuilds` SET `set1`=?, `Set1item1`=?, `Set1item2`=?, `Set1item3`=?, `Set1item4`=?, 
        `Set1item5`=?, `Set1item6`=?, `Set1item7`=?, `Set1item8`=?, `Set1item9`=?, `Set1item10`=?, `set2`=?, `Set2item1`=?, `Set2item2`=?, `Set2item3`=?, 
        `Set2item4`=?, `Set2item5`=?, `Set2item6`=?, `Set2item7`=?, `Set2item8`=?, `Set2item9`=?, `Set2item10`=?, `set3`=?, `Set3item1`=?, `Set3item2`=?, 
        `Set3item3`=?, `Set3item4`=?, `Set3item5`=?, `Set3item6`=?, `Set3item7`=?, `Set3item8`=?, `Set3item9`=?, `Set3item10`=?, `set4`=?, `Set4item1`=?, 
        `Set4item2`=?, `Set4item3`=?, `Set4item4`=?, `Set4item5`=?, `Set4item6`=?, `Set4item7`=?, `Set4item8`=?, `Set4item9`=?, `Set4item10`=?, `set5`=?, 
        `Set5item1`=?, `Set5item2`=?, `Set5item3`=?, `Set5item4`=?, `Set5item5`=?, `Set5item6`=?, `Set5item7`=?, `Set5item8`=?, `Set5item9`=?, `Set5item10`=?, 
        `set6`=?, `Set6item1`=?, `Set6item2`=?, `Set6item3`=?, `Set6item4`=?, `Set6item5`=?, `Set6item6`=?, `Set6item7`=?, `Set6item8`=?, `Set6item9`=?, 
        `Set6item10`=?, `set7`=?, `Set7item1`=?, `Set7item2`=?, `Set7item3`=?, `Set7item4`=?, `Set7item5`=?, `Set7item6`=?, `Set7item7`=?, `Set7item8`=?, 
        `Set7item9`=?, `Set7item10`=?, `set8`=?, `Set8item1`=?, `Set8item2`=?, `Set8item3`=?, `Set8item4`=?, `Set8item5`=?, `Set8item6`=?, `Set8item7`=?, 
        `Set8item8`=?, `Set8item9`=?, `Set8item10`=?, `set9`=?, `Set9item1`=?, `Set9item2`=?, `Set9item3`=?, `Set9item4`=?, `Set9item5`=?, `Set9item6`=?, 
        `Set9item7`=?, `Set9item8`=?, `Set9item9`=?, `Set9item10`=? WHERE `guideID`='$guideID'";

        $stmt = $this->prepare($query);

        $stmt -> bindParam(1, $itemSet1, PDO::PARAM_STR);
        $stmt -> bindParam(2, $Set1item1, PDO::PARAM_STR);
        $stmt -> bindParam(3, $Set1item2, PDO::PARAM_STR);
        $stmt -> bindParam(4, $Set1item3, PDO::PARAM_STR);
        $stmt -> bindParam(5, $Set1item4, PDO::PARAM_STR);
        $stmt -> bindParam(6, $Set1item5, PDO::PARAM_STR);
        $stmt -> bindParam(7, $Set1item6, PDO::PARAM_STR);
        $stmt -> bindParam(8, $Set1item7, PDO::PARAM_STR);
        $stmt -> bindParam(9, $Set1item8, PDO::PARAM_STR);
        $stmt -> bindParam(10, $Set1item9, PDO::PARAM_STR);
        $stmt -> bindParam(11, $Set1item10, PDO::PARAM_STR);
        $stmt -> bindParam(12, $itemSet2, PDO::PARAM_STR);
        $stmt -> bindParam(13, $Set2item1, PDO::PARAM_STR);
        $stmt -> bindParam(14, $Set2item2, PDO::PARAM_STR);
        $stmt -> bindParam(15, $Set2item3, PDO::PARAM_STR);
        $stmt -> bindParam(16, $Set2item4, PDO::PARAM_STR);
        $stmt -> bindParam(17, $Set2item5, PDO::PARAM_STR);
        $stmt -> bindParam(18, $Set2item6, PDO::PARAM_STR);
        $stmt -> bindParam(19, $Set2item7, PDO::PARAM_STR);
        $stmt -> bindParam(20, $Set2item8, PDO::PARAM_STR);
        $stmt -> bindParam(21, $Set2item9, PDO::PARAM_STR);
        $stmt -> bindParam(22, $Set2item10, PDO::PARAM_STR);
        $stmt -> bindParam(23, $itemSet3, PDO::PARAM_STR);
        $stmt -> bindParam(24, $Set3item1, PDO::PARAM_STR);
        $stmt -> bindParam(25, $Set3item2, PDO::PARAM_STR);
        $stmt -> bindParam(26, $Set3item3, PDO::PARAM_STR);
        $stmt -> bindParam(27, $Set3item4, PDO::PARAM_STR);
        $stmt -> bindParam(28, $Set3item5, PDO::PARAM_STR);
        $stmt -> bindParam(29, $Set3item6, PDO::PARAM_STR);
        $stmt -> bindParam(30, $Set3item7, PDO::PARAM_STR);
        $stmt -> bindParam(31, $Set3item8, PDO::PARAM_STR);
        $stmt -> bindParam(32, $Set3item9, PDO::PARAM_STR);
        $stmt -> bindParam(33, $Set3item10, PDO::PARAM_STR);
        $stmt -> bindParam(34, $itemSet4, PDO::PARAM_STR);
        $stmt -> bindParam(35, $Set4item1, PDO::PARAM_STR);
        $stmt -> bindParam(36, $Set4item2, PDO::PARAM_STR);
        $stmt -> bindParam(37, $Set4item3, PDO::PARAM_STR);
        $stmt -> bindParam(38, $Set4item4, PDO::PARAM_STR);
        $stmt -> bindParam(39, $Set4item5, PDO::PARAM_STR);
        $stmt -> bindParam(40, $Set4item6, PDO::PARAM_STR);
        $stmt -> bindParam(41, $Set4item7, PDO::PARAM_STR);
        $stmt -> bindParam(42, $Set4item8, PDO::PARAM_STR);
        $stmt -> bindParam(43, $Set4item9, PDO::PARAM_STR);
        $stmt -> bindParam(44, $Set4item10, PDO::PARAM_STR);
        $stmt -> bindParam(45, $itemSet5, PDO::PARAM_STR);
        $stmt -> bindParam(46, $Set5item1, PDO::PARAM_STR);
        $stmt -> bindParam(47, $Set5item2, PDO::PARAM_STR);
        $stmt -> bindParam(48, $Set5item3, PDO::PARAM_STR);
        $stmt -> bindParam(49, $Set5item4, PDO::PARAM_STR);
        $stmt -> bindParam(50, $Set5item5, PDO::PARAM_STR);
        $stmt -> bindParam(51, $Set5item6, PDO::PARAM_STR);
        $stmt -> bindParam(52, $Set5item7, PDO::PARAM_STR);
        $stmt -> bindParam(53, $Set5item8, PDO::PARAM_STR);
        $stmt -> bindParam(54, $Set5item9, PDO::PARAM_STR);
        $stmt -> bindParam(55, $Set5item10, PDO::PARAM_STR);
        $stmt -> bindParam(56, $itemSet6, PDO::PARAM_STR);
        $stmt -> bindParam(57, $Set6item1, PDO::PARAM_STR);
        $stmt -> bindParam(58, $Set6item2, PDO::PARAM_STR);
        $stmt -> bindParam(59, $Set6item3, PDO::PARAM_STR);
        $stmt -> bindParam(60, $Set6item4, PDO::PARAM_STR);
        $stmt -> bindParam(61, $Set6item5, PDO::PARAM_STR);
        $stmt -> bindParam(62, $Set6item6, PDO::PARAM_STR);
        $stmt -> bindParam(63, $Set6item7, PDO::PARAM_STR);
        $stmt -> bindParam(64, $Set6item8, PDO::PARAM_STR);
        $stmt -> bindParam(65, $Set6item9, PDO::PARAM_STR);
        $stmt -> bindParam(66, $Set6item10, PDO::PARAM_STR);
        $stmt -> bindParam(67, $itemSet7, PDO::PARAM_STR);
        $stmt -> bindParam(68, $Set7item1, PDO::PARAM_STR);
        $stmt -> bindParam(69, $Set7item2, PDO::PARAM_STR);
        $stmt -> bindParam(70, $Set7item3, PDO::PARAM_STR);
        $stmt -> bindParam(71, $Set7item4, PDO::PARAM_STR);
        $stmt -> bindParam(72, $Set7item5, PDO::PARAM_STR);
        $stmt -> bindParam(73, $Set7item6, PDO::PARAM_STR);
        $stmt -> bindParam(74, $Set7item7, PDO::PARAM_STR);
        $stmt -> bindParam(75, $Set7item8, PDO::PARAM_STR);
        $stmt -> bindParam(76, $Set7item9, PDO::PARAM_STR);
        $stmt -> bindParam(77, $Set7item10, PDO::PARAM_STR);
        $stmt -> bindParam(78, $itemSet8, PDO::PARAM_STR);
        $stmt -> bindParam(79, $Set8item1, PDO::PARAM_STR);
        $stmt -> bindParam(80, $Set8item2, PDO::PARAM_STR);
        $stmt -> bindParam(81, $Set8item3, PDO::PARAM_STR);
        $stmt -> bindParam(82, $Set8item4, PDO::PARAM_STR);
        $stmt -> bindParam(83, $Set8item5, PDO::PARAM_STR);
        $stmt -> bindParam(84, $Set8item6, PDO::PARAM_STR);
        $stmt -> bindParam(85, $Set8item7, PDO::PARAM_STR);
        $stmt -> bindParam(86, $Set8item8, PDO::PARAM_STR);
        $stmt -> bindParam(87, $Set8item9, PDO::PARAM_STR);
        $stmt -> bindParam(88, $Set8item10, PDO::PARAM_STR);
        $stmt -> bindParam(89, $itemSet9, PDO::PARAM_STR);
        $stmt -> bindParam(90, $Set9item1, PDO::PARAM_STR);
        $stmt -> bindParam(91, $Set9item2, PDO::PARAM_STR);
        $stmt -> bindParam(92, $Set9item3, PDO::PARAM_STR);
        $stmt -> bindParam(93, $Set9item4, PDO::PARAM_STR);
        $stmt -> bindParam(94, $Set9item5, PDO::PARAM_STR);
        $stmt -> bindParam(95, $Set9item6, PDO::PARAM_STR);
        $stmt -> bindParam(96, $Set9item7, PDO::PARAM_STR);
        $stmt -> bindParam(97, $Set9item8, PDO::PARAM_STR);
        $stmt -> bindParam(98, $Set9item9, PDO::PARAM_STR);
        $stmt -> bindParam(99, $Set9item10, PDO::PARAM_STR);

        if($stmt ->execute()){
            
        } else {
            die("Ein Fehler beim einfügen des Item Builds ist aufgetreten");
        }

    }

};


?>