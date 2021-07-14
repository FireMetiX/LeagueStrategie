<?php 
    // Wichtige Includes hinzufügen
    include_once("../includes/functions.inc.php");
    include_once("../includes/credentials.php");
    include_once("../class/pdoconn.class.php");

    // Session Cookie Name (Key) umbenennen: gegen Hijacking / Spyware
    include_once("../includes/sessionData.php");

    // Verbindung mit Datenbank herstellen
    $instanz = new Dbh($host, $user, $pass, $dbname);

    // Prüft Session Informationen und weist welche zu.
    include_once("../includes/userInformationCheck.php");

    // Variabeln definieren
    $guideID = $_GET['guide'];
    $anzahlSets = 0;
    $buildVorhanden = false;

    $derGuide = $instanz->showGuide($guideID);
    $derBuild = $instanz->showBuild($guideID);

    // Prüft, ob ein Build vorhanden ist
    include_once("../includes/guideLoadBuild.php")

?>

<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon-180x180">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="../css/brain.css">
    <link rel="stylesheet" href="../css/style_guide.css">
    <title>League-Strategie</title>

</head>

<body>

    <!-- navigation -->

    <nav>
        
        <div class="desktopNavigation">

            <div class="desktopNavigationleft">
            
                <a href="../index"><img src="../img/logo/LogoWithText2small.png" alt="Picture of my Logo"></a>

                <ul class="navigationUL">
                    <li class="navigationLI"><a href="../index">Home</a></li>
                    <li class="navigationLI"><a href="guides">Guides</a></li>
                    <li class="navigationLI"><a href="kontakt">Kontakt</a></li>
                    <?php if ($_SESSION["isLoggedin"] == 1) {
                        echo "<li class='navigationLI'><a href='createGuide'>Guide erstellen</a></li>";
                    } ?>
                    <?php if ($_SESSION["isLoggedin"] == 1 && $_SESSION["role"] == "admin") {
                        echo "<li class='navigationLI'><a href='admindashboard'>Admin Dashboard</a></li>";
                    } ?>

                </ul>

            </div>

            <div class="desktopNavigationright">

                <ul class="navigationUL">
                    <?php if($_SESSION["isLoggedin"] == 1){
                        echo "<p>".$_SESSION['username']. "</p>
                        <li class='navigationLI'><a href='login?action=logout'>Logout</a></li>";
                    } else {
                        echo "<li class='navigationLI'><a href='login'>Login</a></li>
                        <li class='navigationLI'><a href='register'>Register</a></li>";
                    } ?>
                </ul>

            </div>

        </div>

        <div class="mobileNavigation">

            <i class="fas fa-bars"></i>

            <div class="mobileNavigationContainer">

                <div class="moblieNavigationWrapper">
                    <div class="mobileLogin">
                    <?php if($_SESSION["isLoggedin"] == 1){
                        echo "<p>".$_SESSION['username']. "</p>
                        <p><a href='login?action=logout'>Logout</a></p>";
                    } else {
                        echo "<p><a href='login'>Login</a></p>
                        <p><a href='register'>Register</a></p>";
                    } ?>
                      
                    </div>
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="guides">Guides</a></li>
                        <li><a href="kontakt">Kontakt</a></li>
                        <?php if ($_SESSION["isLoggedin"] == 1) {
                            echo "<li><a href='createGuide'>Guide erstellen</a></li>";
                        } ?>
                        <?php if ($_SESSION["isLoggedin"] == 1 && $_SESSION["role"] == "admin") {
                        echo "<li><a href='admindashboard'>Admin Dashboard</a></li>";
                        } ?>
                    </ul>
                </div>

            </div> 

        </div>

    </nav>

    <!-- Main -->

    <section class="main">

        <section class="guide">

            <div class="guideContainer">

                <div class="guideheader">
                    <img src="../img/champion/splash/<?=$derGuide['champion']?>_0.jpg" alt="Background image of the Champion <?=$derGuide['champion']?>">
                    <div class="headerInfos">
                        <h1><?=$derGuide['guideTitle']?></h1>
                        <p class="userInfos">By <span><?=$derGuide['username']?></span> | posted in <?=$derGuide['createDate']?></p>
                    </div>
                </div>

                <div class="guideInhalt">

                    <div class="runesAndSpells">

                        <div class="runes">

                            <h2>Runes</h2>

                            <div class="runesContainer">

                                <div class="primaryRunes">

                                    <div class="runedecoration"></div>

                                    <div class="bigRune">
                                        <img src="../img/symbols/runes/<?=ucfirst($derGuide['primaryrune'])?>/<?=ucfirst($derGuide['primaryrune1'])?>/<?=ucfirst($derGuide['primaryrune1'])?>.png" alt="Image of the <?=$derGuide['primaryrune1']?> Rune">
                                    </div>

                                    <img class="runeImages" src="../img/symbols/runes/<?=ucfirst($derGuide['primaryrune'])?>/<?=ucfirst($derGuide['primaryrune2'])?>/<?=ucfirst($derGuide['primaryrune2'])?>.png" alt="Image of the <?=$derGuide['primaryrune2']?> Rune">

                                    <img class="runeImages" src="../img/symbols/runes/<?=ucfirst($derGuide['primaryrune'])?>/<?=ucfirst($derGuide['primaryrune3'])?>/<?=ucfirst($derGuide['primaryrune3'])?>.png" alt="Image of the <?=$derGuide['primaryrune3']?> Rune">

                                    <img class="runeImages" src="../img/symbols/runes/<?=ucfirst($derGuide['primaryrune'])?>/<?=ucfirst($derGuide['primaryrune4'])?>/<?=ucfirst($derGuide['primaryrune4'])?>.png" alt="Image of the <?=$derGuide['primaryrune4']?> Rune">

                                </div>

                                <div class="secondaryRunes">

                                    <div class="runedecoration"></div>

                                    <img class="runeImages" src="../img/symbols/runes/<?=ucfirst($derGuide['secondaryrune'])?>/<?=ucfirst($derGuide['secondaryrune1'])?>/<?=ucfirst($derGuide['secondaryrune1'])?>.png" alt="Image of the <?=$derGuide['secondaryrune1']?> Rune">

                                    <img class="runeImages" src="../img/symbols/runes/<?=ucfirst($derGuide['secondaryrune'])?>/<?=ucfirst($derGuide['secondaryrune2'])?>/<?=ucfirst($derGuide['secondaryrune2'])?>.png" alt="Image of the <?=$derGuide['secondaryrune2']?> Rune">

                                </div>

                                <div class="statBoosts">

                                    <div class="runedecorationsmall"></div>

                                    <div class="statmod">
                                        <img class="statImages" src="../img/symbols/runeStatMods/StatMods<?=$derGuide['runeStatMod1']?>Icon.png" alt="Image of the <?=$derGuide['runeStatMod1']?> stat mod">
                                    </div>

                                    <div class="statmod">
                                        <img class="statImages" src="../img/symbols/runeStatMods/StatMods<?=$derGuide['runeStatMod2']?>Icon.png" alt="Image of the <?=$derGuide['runeStatMod2']?> stat mod">
                                    </div>
                                    
                                    <div class="statmod">
                                        <img class="statImages" src="../img/symbols/runeStatMods/StatMods<?=$derGuide['runeStatMod3']?>Icon.png" alt="Image of the <?=$derGuide['runeStatMod3']?> stat mod">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="spells">

                            <h2>Spells</h2>

                            <div class="spellsContainer">

                                <img src="../img/symbols/championAbilitys/Summoner<?=ucfirst($derGuide['summonerSpell1'])?>.png" alt="Image of the Summoner Spell <?=$derGuide['summonerSpell1']?>">
                                
                                <img src="../img/symbols/championAbilitys/Summoner<?=ucfirst($derGuide['summonerSpell2'])?>.png" alt="Image of the Summoner Spell <?=$derGuide['summonerSpell2']?>">

                            </div>

                        </div>

                    </div>
                    <?php if ($buildVorhanden == true) { ?>
                    
                    <hr>

                    <div class="itemBuild">

                    <?php $jsonversions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
                    $arrayversions = json_decode($jsonversions, true); 
                    $currentVersion = $arrayversions[0];

                    $json = file_get_contents("http://ddragon.leagueoflegends.com/cdn/" . $currentVersion . "/data/en_US/item.json");
                    $array = json_decode($json, true);
                    $items = $array["data"];
                    
                    ?>

                        <h2>Item Build</h2>

                        <div class="itemBuildContainer">

                            <?php 
                                for ($i=1; $i < $anzahlSets + 1; $i++) { 
                                    echo "<div class='itemsets'>
                                        <h3>" . $derBuild['set' . $i] . "</h3>
                                        <div class='itemsetContainer'>";
                                            
                                            for ($x=1; $x < 11; $x++) { 
                                                if ( $derBuild["Set" . $i ."item" . $x] != null ) {
                                                    echo "<div class='item'>
                                                        <img src='../img/symbols/items/" . substr($derBuild['Set' . $i .'item' . $x], 8) . ".png' alt='Picture of the Item " . $items[substr($derBuild['Set' . $i .'item' . $x], 8)]["name"] . "'>
                                                        <p class='itemName'>" . $items[substr($derBuild['Set' . $i .'item' . $x], 8)]["name"] . "</p>
                                                    </div>"; 
                                                }
                                            };

                                        echo "</div>
                                    </div>";
                                }
                            ?>

                        </div>

                    </div>

                    <?php } ?>

                    <hr>

                    <div class="abilityMaxingOrder">
                    
                        <h2>Ability maxing order</h2>

                        <div class="abilityMaxingOrderContainer">

                            <img src="../img/symbols/championAbilitys/<?=$derGuide['abilityMaxing1']?>" alt="Icon of the <?=$derGuide['abilityMaxing1short']?> Ability">

                            <img class="arrow" src="../img/symbols/other/Arrowsmall.png" alt="Icon of an Arrow that shows to the right">

                            <img src="../img/symbols/championAbilitys/<?=$derGuide['abilityMaxing2']?>" alt="Icon of the <?=$derGuide['abilityMaxing2short']?> Ability">

                            <img class="arrow" src="../img/symbols/other/Arrowsmall.png" alt="Icon of an Arrow that shows to the right">

                            <img src="../img/symbols/championAbilitys/<?=$derGuide['abilityMaxing3']?>" alt="Icon of the <?=$derGuide['abilityMaxing3short']?> Ability">

                            <img class="arrow" src="../img/symbols/other/Arrowsmall.png" alt="Icon of an Arrow that shows to the right">

                            <img src="../img/symbols/championAbilitys/<?=$derGuide['abilityMaxing4']?>" alt="Icon of the <?=$derGuide['abilityMaxing4short']?> Ability">

                        </div>

                    </div>

                    <hr>

                    <div class="theGuide">

                        <h2>The Guide</h2>

                        <div class="theGuideContainer">

                        <?php 
                            echo $derGuide['theGuide'];
                        ?>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </section>

    <!-- Footer -->

    <footer>
        <img src="../img/logo/Logosmall.png" alt="Picture of my Logo">
        <p>&copy; COPYRIGHT Damir Mavric</p>
    </footer>

    <!-- SCRIPTS -->

    <!-- <script src="../js/jquery.js"></script> -->
    <script src="../js/toggleNav.js"></script>
    
</body>

</html>