<?php

    // Prüft ob der user eingelogt ist.
    if ($_SESSION["isLoggedin"] == 1) {
    } else {
        die("Du hast keine Berechtigung diese Page aufzurufen");
    }

    // Errors vorbereiten
    $error = false;
    $errors = array();

    // Einige Variabeln vorbereiten
    $userID = $_SESSION["userID"];
    $username = $_SESSION['username'];
    $titleOfGuide = "";
    $editor1 = "";
    $chosenChampion = "";
    $editMode = false;
    $noItemBuild = false;
    $anzahlSets = 0;
    $buildVorhanden = false;

    // Item Builds desinfizieren und speichern 
    $itemSet1 = "";
    $itemSet2 = "";
    $itemSet3 = "";
    $itemSet4 = "";
    $itemSet5 = "";
    $itemSet6 = "";
    $itemSet7 = "";
    $itemSet8 = "";
    $itemSet9 = "";

    $Set1item1 = "";
    $Set1item2 = "";
    $Set1item3 = "";
    $Set1item4 = "";
    $Set1item5 = "";
    $Set1item6 = "";
    $Set1item7 = "";
    $Set1item8 = "";
    $Set1item9 = "";
    $Set1item10 = "";

    $Set2item1 = "";
    $Set2item2 = "";
    $Set2item3 = "";
    $Set2item4 = "";
    $Set2item5 = "";
    $Set2item6 = "";
    $Set2item7 = "";
    $Set2item8 = "";
    $Set2item9 = "";
    $Set2item10 = "";

    $Set3item1 = "";
    $Set3item2 = "";
    $Set3item3 = "";
    $Set3item4 = "";
    $Set3item5 = "";
    $Set3item6 = "";
    $Set3item7 = "";
    $Set3item8 = "";
    $Set3item9 = "";
    $Set3item10 = "";

    $Set4item1 = "";
    $Set4item2 = "";
    $Set4item3 = "";
    $Set4item4 = "";
    $Set4item5 = "";
    $Set4item6 = "";
    $Set4item7 = "";
    $Set4item8 = "";
    $Set4item9 = "";
    $Set4item10 = "";

    $Set5item1 = "";
    $Set5item2 = "";
    $Set5item3 = "";
    $Set5item4 = "";
    $Set5item5 = "";
    $Set5item6 = "";
    $Set5item7 = "";
    $Set5item8 = "";
    $Set5item9 = "";
    $Set5item10 = "";

    $Set6item1 = "";
    $Set6item2 = "";
    $Set6item3 = "";
    $Set6item4 = "";
    $Set6item5 = "";
    $Set6item6 = "";
    $Set6item7 = "";
    $Set6item8 = "";
    $Set6item9 = "";
    $Set6item10 = "";
    
    $Set7item1 = "";
    $Set7item2 = "";
    $Set7item3 = "";
    $Set7item4 = "";
    $Set7item5 = "";
    $Set7item6 = "";
    $Set7item7 = "";
    $Set7item8 = "";
    $Set7item9 = "";
    $Set7item10 = "";

    $Set8item1 = "";
    $Set8item2 = "";
    $Set8item3 = "";
    $Set8item4 = "";
    $Set8item5 = "";
    $Set8item6 = "";
    $Set8item7 = "";
    $Set8item8 = "";
    $Set8item9 = "";
    $Set8item10 = "";

    $Set9item1 = "";
    $Set9item2 = "";
    $Set9item3 = "";
    $Set9item4 = "";
    $Set9item5 = "";
    $Set9item6 = "";
    $Set9item7 = "";
    $Set9item8 = "";
    $Set9item9 = "";
    $Set9item10 = "";

?>