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

    // Seiten spezifische Daten Includen
    include_once("../includes/createGuideGetData.php");

    // Wenn bei guides.php auf edit geklickt wurde, es prüft die Daten und Berechtigungen
    include_once("../includes/createGuideCheckIfEdit.php");

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
    <link rel="stylesheet" href="../css/style_createGuide.css">
    <script src="../ckeditor/ckeditor.js"></script>
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

        <div class="createGuideContainer">

            <?php if (isset($_GET["info"]) && $_GET["info"] == "done") { 
                echo "<div class='successContainer'><p>Dein Guide wurde erfolgreich erstellt!</p></div>";
             } else if (isset($_GET["info"]) && $_GET["info"] == "doneEdit") {
                echo "<div class='successContainer'><p>Dein Guide wurde erfolgreich geupdated!!</p></div>";
             } ?>

            <form method="POST">

                <label class="titleOfGuide" for="titleOfGuide">Your Title:
                    <input type="text" name="titleOfGuide" id="titleOfGuide" value="<?=$titleOfGuide?>">
                </label>

                <label class="championSelection" for="championSelection">Your Champion:
                    <select id="championSelect" name="championSelection">
                        <option value="0">Choose a Champion...</option>
                        <?php
                        // Get Champion data from json file
                        $myJsonFile = file_get_contents("../json/champion.json");
                        $array = json_decode($myJsonFile, true);
                        $championarray = $array["data"];

                        // Making Selection of every Champion
                        foreach($championarray as $champion){ ?>
                            <option value=<?php 
                            echo "'" . $champion["id"] . "'";
                            if ( $champion["name"] == $chosenChampion ) {
                                 echo "selected";
                                 } ?>
                                 >
                                 <?php echo $champion["name"]; ?></option>
                        <?php } ?>  

                  </select>
                </label>

                <p class="createGuideP">Your Role:</p>

                <div class="roleSelectionContainer">

                    <label>
                        <input type="radio" name="role" value="top" checked>
                        <div class="roleSelection"> Top</div>
                    </label>

                    <label>
                        <input type="radio" name="role" value="jungle">
                        <div class="roleSelection"> Jungle</div>
                    </label>

                    <label>
                        <input type="radio" name="role" value="Mid">
                        <div class="roleSelection"> Mid</div>
                    </label>

                    <label>
                        <input type="radio" name="role" value="Bot">
                        <div class="roleSelection"> Bot</div>
                    </label>

                    <label>
                        <input type="radio" name="role" value="Support">
                        <div class="roleSelection"> Support</div>
                    </label>

                </div>

                <p class="createGuideP">Your Runes:</p>
        
                <div class="runeSelectionContainer">

                    <p class="runeSelectionSmallTitle">Primary Rune:</p>

                    <div class="runeSelectionWrapper">

                        <label>
                            <input type="radio" name="primaryRune" value="precision" checked>
                            <div class="primaryRuneSelection" id="precisionSelection"> <img src="../img/symbols/runeSymbols/7201_Precision.png" alt="Image of the Precision Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune" value="domination">
                            <div class="primaryRuneSelection" id="dominationSelection"> <img src="../img/symbols/runeSymbols/7200_Domination.png" alt="Image of the Domination Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune" value="sorcery">
                            <div class="primaryRuneSelection" id="sorcerySelection"> <img src="../img/symbols/runeSymbols/7202_Sorcery.png" alt="Image of the Sorcery Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune" value="resolve">
                            <div class="primaryRuneSelection" id="resolveSelection"> <img src="../img/symbols/runeSymbols/7204_Resolve.png" alt="Image of the Resolve Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune" value="inspiration">
                            <div class="primaryRuneSelection" id="inspirationSelection"> <img src="../img/symbols/runeSymbols/7203_Whimsy.png" alt="Image of the Inspiration Rune set"></div>
                        </label>

                    </div>

                </div>

                <div class="primaryRuneContainer">
                
                    <div class="precisionRunes1 bigRuneSelectContainer">
                        
                        <label>
                            <input id="precisioncheck" type="radio" name="primaryRune1" value="presstheattack" checked>
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Precision/PressTheAttack/PressTheAttack.png" alt="Image of the Precision Rune Press the Attack"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="lethaltempo">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Precision/LethalTempo/LethalTempo.png" alt="Image of the Precision Rune lethal tempo"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="fleetfootwork">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Precision/Fleetfootwork/Fleetfootwork.png" alt="Image of the Precision Rune fleet footwork"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="conqueror">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Precision/Conqueror/Conqueror.png" alt="Image of the Precision Rune conqueror"></div>
                        </label>
                    
                    </div>

                    <div class="dominationRunes1 bigRuneSelectContainer">
                        
                        <label>
                            <input id="dominationcheck" type="radio" name="primaryRune1" value="electrocute">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Domination/Electrocute/Electrocute.png" alt="Image of the Domination Rune Electrocute"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="predator">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Domination/Predator/Predator.png" alt="Image of the Domination Rune Predator"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="darkharvest">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Domination/DarkHarvest/DarkHarvest.png" alt="Image of the Domination Rune Dark Harvest"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="hailofblades">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Domination/Hailofblades/Hailofblades.png" alt="Image of the Domination Rune Hail of Blades"></div>
                        </label>
                    
                    </div>

                    <div class="sorceryRunes1 bigRuneSelectContainer">
                        
                        <label>
                            <input id="sorcerycheck" type="radio" name="primaryRune1" value="summonaery">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Sorcery/SummonAery/SummonAery.png" alt="Image of the Sorcery Rune Summon Aery"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="arcanecomet">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Sorcery/ArcaneComet/ArcaneComet.png" alt="Image of the Sorcery Rune Arcane Comet"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="phaserush">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Sorcery/PhaseRush/PhaseRush.png" alt="Image of the Sorcery Rune Phase Rush"></div>
                        </label>
                    
                    </div>

                    <div class="resolveRunes1 bigRuneSelectContainer">
                        
                        <label>
                            <input id="resolvecheck" type="radio" name="primaryRune1" value="graspoftheundying">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Resolve/GraspOfTheUndying/GraspOfTheUndying.png" alt="Image of the Resolve Rune Grasp Of the Undying"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="Aftershock">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Resolve/Aftershock/Aftershock.png" alt="Image of the Resolve Rune Aftershock"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="guardian">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Resolve/Guardian/Guardian.png" alt="Image of the Resolve Rune Guardian"></div>
                        </label>
                    
                    </div>

                    <div class="inspirationRunes1 bigRuneSelectContainer">
                        
                        <label>
                            <input id="inspirationcheck" type="radio" name="primaryRune1" value="glacialAugment">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Inspiration/GlacialAugment/GlacialAugment.png" alt="Image of the Inspiration Rune Glacial Augment"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="unsealedspellbook">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Inspiration/UnsealedSpellbook/UnsealedSpellbook.png" alt="Image of the Inspiration Rune Unsealed Spellbook"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune1" value="Omnistone">
                            <div class="bigRuneSelection"> <img src="../img/symbols/runes/Inspiration/Omnistone/Omnistone.png" alt="Image of the Inspiration Rune Omnistone"></div>
                        </label>
                    
                    </div>

                    <div class="precisionRunes2 smallRuneSelectContainer1">
                        
                        <label>
                            <input id="precisioncheck2" type="radio" name="primaryRune2" value="overheal" checked>
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/Overheal/Overheal.png" alt="Image of the Precision Rune Overheal"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="triumph">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/Triumph/Triumph.png" alt="Image of the Precision Rune Triumph"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="presenceOfMind">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/PresenceOfMind/PresenceOfMind.png" alt="Image of the Precision Rune Presence Of Mind"></div>
                        </label>
                    
                    </div>

                    <div class="precisionRunes3 smallRuneSelectContainer2">
                        
                        <label>
                            <input id="precisioncheck3" type="radio" name="primaryRune3" value="legendAlacrity" checked>
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendAlacrity/LegendAlacrity.png" alt="Image of the Precision Rune Legend Alacrity"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="legendTenacity">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendTenacity/LegendTenacity.png" alt="Image of the Precision Rune Legend Tenacity"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="legendBloodline">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendBloodline/LegendBloodline.png" alt="Image of the Precision Rune Legend Bloodline"></div>
                        </label>
                    
                    </div>

                    <div class="precisionRunes4 smallRuneSelectContainer3">
                        
                        <label>
                            <input id="precisioncheck4" type="radio" name="primaryRune4" value="coupDeGrace" checked>
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/CoupDeGrace/CoupDeGrace.png" alt="Image of the Precision Rune Coup De Grace"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="cutDown">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/CutDown/CutDown.png" alt="Image of the Precision Rune Cut Down"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="lastStand">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LastStand/LastStand.png" alt="Image of the Precision Rune Last Stand"></div>
                        </label>
                    
                    </div>

                    <div class="dominationRunes2 smallRuneSelectContainer1">
                        
                        <label>
                            <input id="dominationcheck2" type="radio" name="primaryRune2" value="cheapShot">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/CheapShot/CheapShot.png" alt="Image of the Domination Rune CheapShot"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="tasteOfBlood">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/TasteOfBlood/TasteOfBlood.png" alt="Image of the Domination Rune Taste Of Blood"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="suddenImpact">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/SuddenImpact/SuddenImpact.png" alt="Image of the Domination Rune Sudden Impact"></div>
                        </label>
                    
                    </div>

                    <div class="dominationRunes3 smallRuneSelectContainer2">
                        
                        <label>
                            <input id="dominationcheck3" type="radio" name="primaryRune3" value="zombieWard">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/ZombieWard/ZombieWard.png" alt="Image of the Domination Rune Zombie Ward"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="ghostPoro">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/GhostPoro/GhostPoro.png" alt="Image of the Domination Rune Ghost Poro"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="eyeballCollection">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/EyeballCollection/EyeballCollection.png" alt="Image of the Domination Rune Eyeball Collection"></div>
                        </label>
                    
                    </div>

                    <div class="dominationRunes4 smallRuneSelectContainer3">
                        
                        <label>
                            <input id="dominationcheck4" type="radio" name="primaryRune4" value="ravenousHunter">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/RavenousHunter/RavenousHunter.png" alt="Image of the Domination Rune Ravenous Hunter"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="ingeniousHunter">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/IngeniousHunter/IngeniousHunter.png" alt="Image of the Domination Rune Ingenious Hunter"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="relentlessHunter">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/RelentlessHunter/RelentlessHunter.png" alt="Image of the Domination Rune Relentless Hunter"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="ultimateHunter">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/UltimateHunter/UltimateHunter.png" alt="Image of the Domination Rune Ultimate Hunter"></div>
                        </label>
                    
                    </div>

                    <div class="sorceryRunes2 smallRuneSelectContainer1">
                        
                        <label>
                            <input id="sorcerycheck2" type="radio" name="primaryRune2" value="nullifyingOrb">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/NullifyingOrb/NullifyingOrb.png" alt="Image of the Sorcery Rune Nullifying Orb"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="manaflowBand">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/ManaflowBand/ManaflowBand.png" alt="Image of the Sorcery Rune Manaflow Band"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="NimbusCloak">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/NimbusCloak/NimbusCloak.png" alt="Image of the Sorcery Rune Nimbus Cloak"></div>
                        </label>
                    
                    </div>

                    <div class="sorceryRunes3 smallRuneSelectContainer2">
                        
                        <label>
                            <input id="sorcerycheck3" type="radio" name="primaryRune3" value="transcendence">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Transcendence/Transcendence.png" alt="Image of the Sorcery Rune Transcendence"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="Celerity">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Celerity/Celerity.png" alt="Image of the Sorcery Rune Celerity"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="absoluteFocus">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/AbsoluteFocus/AbsoluteFocus.png" alt="Image of the Sorcery Rune Absolute Focus"></div>
                        </label>
                    
                    </div>

                    <div class="sorceryRunes4 smallRuneSelectContainer3">
                        
                        <label>
                            <input id="sorcerycheck4" type="radio" name="primaryRune4" value="scorch">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Scorch/Scorch.png" alt="Image of the Sorcery Rune Scorch"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="waterwalking">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Waterwalking/Waterwalking.png" alt="Image of the Sorcery Rune Waterwalking"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="gatheringStorm">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/GatheringStorm/GatheringStorm.png" alt="Image of the Sorcery Rune Gathering Storm"></div>
                        </label>
                    
                    </div>

                    <div class="resolveRunes2 smallRuneSelectContainer1">
                        
                        <label>
                            <input id="resolvecheck2" type="radio" name="primaryRune2" value="demolish">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Demolish/Demolish.png" alt="Image of the Resolve Rune Demolish"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="fontOfLife">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/FontOfLife/FontOfLife.png" alt="Image of the Resolve Rune Font Of Life"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="shieldBash">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/MirrorShell/MirrorShell.png" alt="Image of the Resolve Rune Shield Bash"></div>
                        </label>
                    
                    </div>

                    <div class="resolveRunes3 smallRuneSelectContainer2">
                        
                        <label>
                            <input id="resolvecheck3" type="radio" name="primaryRune3" value="conditioning">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Conditioning/Conditioning.png" alt="Image of the Resolve Rune Conditioning"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="secondWind">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/SecondWind/SecondWind.png" alt="Image of the Resolve Rune SecondWind"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="bonePlating">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/BonePlating/BonePlating.png" alt="Image of the Resolve Rune Bone Plating"></div>
                        </label>
                    
                    </div>

                    <div class="resolveRunes4 smallRuneSelectContainer3">
                        
                        <label>
                            <input id="resolvecheck4" type="radio" name="primaryRune4" value="overgrowth">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Overgrowth/Overgrowth.png" alt="Image of the Resolve Rune Overgrowth"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="revitalize">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Revitalize/Revitalize.png" alt="Image of the Resolve Rune Revitalize"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="unflinching">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Unflinching/Unflinching.png" alt="Image of the Resolve Rune Unflinching"></div>
                        </label>
                    
                    </div>

                    <div class="inspirationRunes2 smallRuneSelectContainer1">
                        
                        <label>
                            <input id="inspirationcheck2" type="radio" name="primaryRune2" value="hextechFlashtraption">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/HextechFlashtraption/HextechFlashtraption.png" alt="Image of the Inspiration Rune Hextech Flashtraption"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="magicalFootwear">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/MagicalFootwear/MagicalFootwear.png" alt="Image of the Inspiration Rune Magical Footwear"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune2" value="perfectTiming">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/PerfectTiming/PerfectTiming.png" alt="Image of the Inspiration Rune Perfect Timing"></div>
                        </label>
                    
                    </div>

                    <div class="inspirationRunes3 smallRuneSelectContainer2">
                        
                        <label>
                            <input id="inspirationcheck3" type="radio" name="primaryRune3" value="futuresMarket">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/FuturesMarket/FuturesMarket.png" alt="Image of the Inspiration Rune Futures Market"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="minionDematerializer">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/MinionDematerializer/MinionDematerializer.png" alt="Image of the Inspiration Rune Minion Dematerializer"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune3" value="biscuitDelivery">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/BiscuitDelivery/BiscuitDelivery.png" alt="Image of the Inspiration Rune Biscuit Delivery"></div>
                        </label>
                    
                    </div>

                    <div class="inspirationRunes4 smallRuneSelectContainer3">
                        
                        <label>
                            <input id="inspirationcheck4" type="radio" name="primaryRune4" value="cosmicInsight">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/CosmicInsight/CosmicInsight.png" alt="Image of the Inspiration Rune Cosmic Insight"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="approachVelocity">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/ApproachVelocity/ApproachVelocity.png" alt="Image of the Inspiration Rune Approach Velocity"></div>
                        </label>
                        <label>
                            <input type="radio" name="primaryRune4" value="timeWarpTonic">
                            <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/TimeWarpTonic/TimeWarpTonic.png" alt="Image of the Inspiration Rune TimeWarp Tonic"></div>
                        </label>
                    
                    </div>

                </div>
        
                <div class="secondaryRuneSelectionContainer">

                    <p class="runeSelectionSmallTitle">Secondary Rune:</p>

                    <div class="runeSelectionWrapper">

                        <label>
                            <input type="radio" name="secondaryRune" value="precision">
                            <div class="secondaryRuneSelection" id="secondaryprecisionSelection"> <img src="../img/symbols/runeSymbols/7201_Precision.png" alt="Image of the Precision Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="secondaryRune" value="domination" checked>
                            <div class="secondaryRuneSelection" id="secondarydominationSelection"> <img src="../img/symbols/runeSymbols/7200_Domination.png" alt="Image of the Domination Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="secondaryRune" value="sorcery">
                            <div class="secondaryRuneSelection" id="secondarysorcerySelection"> <img src="../img/symbols/runeSymbols/7202_Sorcery.png" alt="Image of the Sorcery Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="secondaryRune" value="resolve">
                            <div class="secondaryRuneSelection" id="secondaryresolveSelection"> <img src="../img/symbols/runeSymbols/7204_Resolve.png" alt="Image of the Resolve Rune set"></div>
                        </label>
                        <label>
                            <input type="radio" name="secondaryRune" value="inspiration">
                            <div class="secondaryRuneSelection" id="secondaryinspirationSelection"> <img src="../img/symbols/runeSymbols/7203_Whimsy.png" alt="Image of the Inspiration Rune set"></div>
                        </label>

                    </div>

                </div>

                <div class="secondaryRuneContainer">

                    <div class="doubleRuneDivsContainer1">

                        <div class="secondaryprecisionRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input id="secondaryprecisioncheck" type="radio" name="secondaryRune1" value="overheal" checked>
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/Overheal/Overheal.png" alt="Image of the Precision Rune Overheal"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="triumph">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/Triumph/Triumph.png" alt="Image of the Precision Rune Triumph"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="presenceOfMind">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/PresenceOfMind/PresenceOfMind.png" alt="Image of the Precision Rune Presence Of Mind"></div>
                            </label>
                        </div>
                        <div class="secondaryprecisionRunes secondarySmallRuneSelectContainer">
                            <label>
                                <input type="radio" name="secondaryRune1" value="legendAlacrity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendAlacrity/LegendAlacrity.png" alt="Image of the Precision Rune Legend Alacrity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="legendTenacity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendTenacity/LegendTenacity.png" alt="Image of the Precision Rune Legend Tenacity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="legendBloodline">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendBloodline/LegendBloodline.png" alt="Image of the Precision Rune Legend Bloodline"></div>
                            </label>
                        </div>
                        <div class="secondaryprecisionRunes secondarySmallRuneSelectContainer">
                            <label>
                                <input type="radio" name="secondaryRune1" value="coupDeGrace">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/CoupDeGrace/CoupDeGrace.png" alt="Image of the Precision Rune Coup De Grace"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="cutDown">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/CutDown/CutDown.png" alt="Image of the Precision Rune Cut Down"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="lastStand">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LastStand/LastStand.png" alt="Image of the Precision Rune Last Stand"></div>
                            </label>
                        </div>

                        <div class="secondarydominationRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input id="secondarydominationcheck" type="radio" name="secondaryRune1" value="cheapShot" checked>
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/CheapShot/CheapShot.png" alt="Image of the Domination Rune CheapShot"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="tasteOfBlood">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/TasteOfBlood/TasteOfBlood.png" alt="Image of the Domination Rune Taste Of Blood"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="suddenImpact">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/SuddenImpact/SuddenImpact.png" alt="Image of the Domination Rune Sudden Impact"></div>
                            </label>
                    
                        </div>

                        <div class="secondarydominationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="zombieWard">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/ZombieWard/ZombieWard.png" alt="Image of the Domination Rune Zombie Ward"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="ghostPoro">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/GhostPoro/GhostPoro.png" alt="Image of the Domination Rune Ghost Poro"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="eyeballCollection">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/EyeballCollection/EyeballCollection.png" alt="Image of the Domination Rune Eyeball Collection"></div>
                            </label>
                        
                        </div>

                        <div class="secondarydominationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="ravenousHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/RavenousHunter/RavenousHunter.png" alt="Image of the Domination Rune Ravenous Hunter"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="ingeniousHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/IngeniousHunter/IngeniousHunter.png" alt="Image of the Domination Rune Ingenious Hunter"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="relentlessHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/RelentlessHunter/RelentlessHunter.png" alt="Image of the Domination Rune Relentless Hunter"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="ultimateHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/UltimateHunter/UltimateHunter.png" alt="Image of the Domination Rune Ultimate Hunter"></div>
                            </label>
                        
                        </div>

                        <div class="secondarysorceryRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input id="secondarysorcerycheck" type="radio" name="secondaryRune1" value="nullifyingOrb">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/NullifyingOrb/NullifyingOrb.png" alt="Image of the Sorcery Rune Nullifying Orb"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="manaflowBand">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/ManaflowBand/ManaflowBand.png" alt="Image of the Sorcery Rune Manaflow Band"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="NimbusCloak">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/NimbusCloak/NimbusCloak.png" alt="Image of the Sorcery Rune Nimbus Cloak"></div>
                            </label>
                    
                        </div>

                        <div class="secondarysorceryRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="transcendence">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Transcendence/Transcendence.png" alt="Image of the Sorcery Rune Transcendence"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="celerity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Celerity/Celerity.png" alt="Image of the Sorcery Rune Celerity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="absoluteFocus">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/AbsoluteFocus/AbsoluteFocus.png" alt="Image of the Sorcery Rune Absolute Focus"></div>
                            </label>
                        
                        </div>

                        <div class="secondarysorceryRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="scorch">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Scorch/Scorch.png" alt="Image of the Sorcery Rune Scorch"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="waterwalking">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Waterwalking/Waterwalking.png" alt="Image of the Sorcery Rune Waterwalking"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="gatheringStorm">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/GatheringStorm/GatheringStorm.png" alt="Image of the Sorcery Rune Gathering Storm"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryresolveRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input id="secondaryresolvecheck" type="radio" name="secondaryRune1" value="demolish">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Demolish/Demolish.png" alt="Image of the Resolve Rune Demolish"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="fontOfLife">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/FontOfLife/FontOfLife.png" alt="Image of the Resolve Rune Font Of Life"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="shieldBash">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/MirrorShell/MirrorShell.png" alt="Image of the Resolve Rune Shield Bash"></div>
                            </label>
                    
                        </div>

                        <div class="secondaryresolveRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="conditioning">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Conditioning/Conditioning.png" alt="Image of the Resolve Rune Conditioning"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="secondWind">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/SecondWind/SecondWind.png" alt="Image of the Resolve Rune SecondWind"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="bonePlating">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/BonePlating/BonePlating.png" alt="Image of the Resolve Rune Bone Plating"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryresolveRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="overgrowth">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Overgrowth/Overgrowth.png" alt="Image of the Resolve Rune Overgrowth"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="revitalize">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Revitalize/Revitalize.png" alt="Image of the Resolve Rune Revitalize"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="unflinching">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Unflinching/Unflinching.png" alt="Image of the Resolve Rune Unflinching"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryinspirationRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input id="secondaryinspirationcheck" type="radio" name="secondaryRune1" value="hextechFlashtraption">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/HextechFlashtraption/HextechFlashtraption.png" alt="Image of the Inspiration Rune Hextech Flashtraption"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="magicalFootwear">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/MagicalFootwear/MagicalFootwear.png" alt="Image of the Inspiration Rune Magical Footwear"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="perfectTiming">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/PerfectTiming/PerfectTiming.png" alt="Image of the Inspiration Rune Perfect Timing"></div>
                            </label>
                    
                        </div>

                        <div class="secondaryinspirationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="futuresMarket">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/FuturesMarket/FuturesMarket.png" alt="Image of the Inspiration Rune Futures Market"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="minionDematerializer">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/MinionDematerializer/MinionDematerializer.png" alt="Image of the Inspiration Rune Minion Dematerializer"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="biscuitDelivery">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/BiscuitDelivery/BiscuitDelivery.png" alt="Image of the Inspiration Rune Biscuit Delivery"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryinspirationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune1" value="cosmicInsight">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/CosmicInsight/CosmicInsight.png" alt="Image of the Inspiration Rune Cosmic Insight"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="approachVelocity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/ApproachVelocity/ApproachVelocity.png" alt="Image of the Inspiration Rune Approach Velocity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune1" value="timeWarpTonic">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/TimeWarpTonic/TimeWarpTonic.png" alt="Image of the Inspiration Rune TimeWarp Tonic"></div>
                            </label>
                        
                        </div>

                    </div>

                    <div class="doubleRuneDivsContainer2">

                        <div class="secondaryprecisionRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune2" value="overheal">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/Overheal/Overheal.png" alt="Image of the Precision Rune Overheal"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="triumph">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/Triumph/Triumph.png" alt="Image of the Precision Rune Triumph"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="presenceOfMind">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/PresenceOfMind/PresenceOfMind.png" alt="Image of the Precision Rune Presence Of Mind"></div>
                            </label>
                        </div>
                        <div class="secondaryprecisionRunes secondarySmallRuneSelectContainer">
                            <label>
                                <input id="secondaryprecisioncheck2" type="radio" name="secondaryRune2" value="legendAlacrity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendAlacrity/LegendAlacrity.png" alt="Image of the Precision Rune Legend Alacrity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="legendTenacity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendTenacity/LegendTenacity.png" alt="Image of the Precision Rune Legend Tenacity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="legendBloodline">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LegendBloodline/LegendBloodline.png" alt="Image of the Precision Rune Legend Bloodline"></div>
                            </label>
                        </div>
                        <div class="secondaryprecisionRunes secondarySmallRuneSelectContainer">
                            <label>
                                <input type="radio" name="secondaryRune2" value="coupDeGrace">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/CoupDeGrace/CoupDeGrace.png" alt="Image of the Precision Rune Coup De Grace"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="cutDown">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/CutDown/CutDown.png" alt="Image of the Precision Rune Cut Down"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="lastStand">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Precision/LastStand/LastStand.png" alt="Image of the Precision Rune Last Stand"></div>
                            </label>
                        </div>

                        <div class="secondarydominationRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input type="radio" name="secondaryRune2" value="cheapShot">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/CheapShot/CheapShot.png" alt="Image of the Domination Rune CheapShot"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="tasteOfBlood">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/TasteOfBlood/TasteOfBlood.png" alt="Image of the Domination Rune Taste Of Blood"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="suddenImpact">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/SuddenImpact/SuddenImpact.png" alt="Image of the Domination Rune Sudden Impact"></div>
                            </label>
                    
                        </div>

                        <div class="secondarydominationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input id="secondarydominationcheck2" type="radio" name="secondaryRune2" value="zombieWard" checked>
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/ZombieWard/ZombieWard.png" alt="Image of the Domination Rune Zombie Ward"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="ghostPoro">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/GhostPoro/GhostPoro.png" alt="Image of the Domination Rune Ghost Poro"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="eyeballCollection">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/EyeballCollection/EyeballCollection.png" alt="Image of the Domination Rune Eyeball Collection"></div>
                            </label>
                        
                        </div>

                        <div class="secondarydominationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune2" value="ravenousHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/RavenousHunter/RavenousHunter.png" alt="Image of the Domination Rune Ravenous Hunter"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="ingeniousHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/IngeniousHunter/IngeniousHunter.png" alt="Image of the Domination Rune Ingenious Hunter"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="relentlessHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/RelentlessHunter/RelentlessHunter.png" alt="Image of the Domination Rune Relentless Hunter"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="ultimateHunter">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Domination/UltimateHunter/UltimateHunter.png" alt="Image of the Domination Rune Ultimate Hunter"></div>
                            </label>
                        
                        </div>

                        <div class="secondarysorceryRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input type="radio" name="secondaryRune2" value="nullifyingOrb">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/NullifyingOrb/NullifyingOrb.png" alt="Image of the Sorcery Rune Nullifying Orb"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="manaflowBand">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/ManaflowBand/ManaflowBand.png" alt="Image of the Sorcery Rune Manaflow Band"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="NimbusCloak">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/NimbusCloak/NimbusCloak.png" alt="Image of the Sorcery Rune Nimbus Cloak"></div>
                            </label>
                    
                        </div>

                        <div class="secondarysorceryRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input id="secondarysorcerycheck2" type="radio" name="secondaryRune2" value="transcendence">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Transcendence/Transcendence.png" alt="Image of the Sorcery Rune Transcendence"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="celerity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Celerity/Celerity.png" alt="Image of the Sorcery Rune Celerity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="absoluteFocus">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/AbsoluteFocus/AbsoluteFocus.png" alt="Image of the Sorcery Rune Absolute Focus"></div>
                            </label>
                        
                        </div>

                        <div class="secondarysorceryRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune2" value="scorch">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Scorch/Scorch.png" alt="Image of the Sorcery Rune Scorch"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="waterwalking">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/Waterwalking/Waterwalking.png" alt="Image of the Sorcery Rune Waterwalking"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="gatheringStorm">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Sorcery/GatheringStorm/GatheringStorm.png" alt="Image of the Sorcery Rune Gathering Storm"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryresolveRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input type="radio" name="secondaryRune2" value="demolish">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Demolish/Demolish.png" alt="Image of the Resolve Rune Demolish"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="fontOfLife">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/FontOfLife/FontOfLife.png" alt="Image of the Resolve Rune Font Of Life"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="shieldBash">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/MirrorShell/MirrorShell.png" alt="Image of the Resolve Rune Shield Bash"></div>
                            </label>
                    
                        </div>

                        <div class="secondaryresolveRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input id="secondaryresolvecheck2" type="radio" name="secondaryRune2" value="conditioning">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Conditioning/Conditioning.png" alt="Image of the Resolve Rune Conditioning"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="secondWind">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/SecondWind/SecondWind.png" alt="Image of the Resolve Rune SecondWind"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="bonePlating">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/BonePlating/BonePlating.png" alt="Image of the Resolve Rune Bone Plating"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryresolveRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune2" value="overgrowth">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Overgrowth/Overgrowth.png" alt="Image of the Resolve Rune Overgrowth"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="revitalize">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Revitalize/Revitalize.png" alt="Image of the Resolve Rune Revitalize"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="unflinching">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Resolve/Unflinching/Unflinching.png" alt="Image of the Resolve Rune Unflinching"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryinspirationRunes secondarySmallRuneSelectContainer">
                        
                            <label>
                                <input type="radio" name="secondaryRune2" value="hextechFlashtraption">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/HextechFlashtraption/HextechFlashtraption.png" alt="Image of the Inspiration Rune Hextech Flashtraption"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="magicalFootwear">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/MagicalFootwear/MagicalFootwear.png" alt="Image of the Inspiration Rune Magical Footwear"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="perfectTiming">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/PerfectTiming/PerfectTiming.png" alt="Image of the Inspiration Rune Perfect Timing"></div>
                            </label>
                    
                        </div>

                        <div class="secondaryinspirationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input id="secondaryinspirationcheck2" type="radio" name="secondaryRune2" value="futuresMarket">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/FuturesMarket/FuturesMarket.png" alt="Image of the Inspiration Rune Futures Market"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="minionDematerializer">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/MinionDematerializer/MinionDematerializer.png" alt="Image of the Inspiration Rune Minion Dematerializer"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="biscuitDelivery">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/BiscuitDelivery/BiscuitDelivery.png" alt="Image of the Inspiration Rune Biscuit Delivery"></div>
                            </label>
                        
                        </div>

                        <div class="secondaryinspirationRunes secondarySmallRuneSelectContainer">
                            
                            <label>
                                <input type="radio" name="secondaryRune2" value="cosmicInsight">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/CosmicInsight/CosmicInsight.png" alt="Image of the Inspiration Rune Cosmic Insight"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="approachVelocity">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/ApproachVelocity/ApproachVelocity.png" alt="Image of the Inspiration Rune Approach Velocity"></div>
                            </label>
                            <label>
                                <input type="radio" name="secondaryRune2" value="timeWarpTonic">
                                <div class="smallRuneSelection"> <img src="../img/symbols/runes/Inspiration/TimeWarpTonic/TimeWarpTonic.png" alt="Image of the Inspiration Rune TimeWarp Tonic"></div>
                            </label>
                        
                        </div>
                    
                    </div>

                </div>

                <div class="runeStatMods">
                
                    <div class="runeStatsModsContainer">
                            
                        <label>
                            <input type="radio" name="runeStatMod1" value="AdaptiveForce" checked>
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsAdaptiveForceIcon.png" alt="Image of the stat modification Rune Adaptive force"></div>
                        </label>
                        <label>
                            <input type="radio" name="runeStatMod1" value="AttackSpeed">
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsAttackSpeedIcon.png" alt="Image of the stat modification Rune Attack Speed"></div>
                        </label>
                        <label>
                            <input type="radio" name="runeStatMod1" value="CDRScaling">
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsCDRScalingIcon.png " alt="Image of the stat modification Rune Ability Haste"></div>
                        </label>

                    </div>

                    <div class="runeStatsModsContainer">
                            
                        <label>
                            <input type="radio" name="runeStatMod2" value="AdaptiveForce" checked>
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsAdaptiveForceIcon.png" alt="Image of the stat modification Rune Adaptive force"></div>
                        </label>
                        <label>
                            <input type="radio" name="runeStatMod2" value="Armor">
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsArmorIcon.png" alt="Image of the stat modification Rune Armor"></div>
                        </label>
                        <label>
                            <input type="radio" name="runeStatMod2" value="MagicRes">
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsMagicResIcon.png " alt="Image of the stat modification Rune Magic Resistance"></div>
                        </label>

                    </div>

                    <div class="runeStatsModsContainer">
                            
                        <label>
                            <input type="radio" name="runeStatMod3" value="HealthScaling" checked>
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsHealthScalingIcon.png" alt="Image of the stat modification Rune Health per Level"></div>
                        </label>
                        <label>
                            <input type="radio" name="runeStatMod3" value="Armor">
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsArmorIcon.png" alt="Image of the stat modification Rune Armor"></div>
                        </label>
                        <label>
                            <input type="radio" name="runeStatMod3" value="MagicRes">
                            <div class="runeStatModSelection"> <img src="../img/symbols/runeStatMods/StatModsMagicResIcon.png" alt="Image of the stat modification Rune Magic Resistance"></div>
                        </label>

                    </div>
                         
                </div>

                <div class="summonerSpells">
                
                    <p class="createGuideP">Your Summoner Spells:</p>

                    <div class="summonerSpellsContainer">

                        <label>
                            <input type="checkbox" name="summonerspells[cleanse]" value="cleanse">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/Summonercleanse.png" alt="Image of the Summoner Spell Cleanse"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[cleanse]" value="barrier">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerBarrier.png" alt="Image of the Summoner Spell Barrier"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[ignite]" value="ignite">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerIgnite.png" alt="Image of the Summoner Spell Ignite"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[exhaust]" value="exhaust">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerExhaust.png" alt="Image of the Summoner Spell Exhaust"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[flash]" value="flash">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerFlash.png" alt="Image of the Summoner Spell Flash"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[ghost]" value="ghost">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/Summonerghost.png" alt="Image of the Summoner Spell Ghost"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[heal]" value="heal">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerHeal.png" alt="Image of the Summoner Spell Heal"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[smite]" value="smite">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerSmite.png" alt="Image of the Summoner Spell Smite"></div>
                        </label>

                        <label>
                            <input type="checkbox" name="summonerspells[teleport]" value="teleport">
                            <div class="abilityIcon"> <img src="../img/symbols/championAbilitys/SummonerTeleport.png" alt="Image of the Summoner Spell Teleport"></div>
                        </label>

                    </div>
                
                </div>

                <div class="itemBuild">

                    <p class="createGuideP">Your Item Build:</p>

                    <div class="itemBuildContainer">
                        <div class="itemSets">
                            <h2>Item Sets</h2>

                            <p class="addSet"><i class="fas fa-plus"></i> Add new set</p>

                            <div class="itemSetsWrapper">

                                <?php if ($editMode == true && $buildVorhanden == true ) {

                                    $jsonversions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
                                    $arrayversions = json_decode($jsonversions, true); 
                                    $currentVersion = $arrayversions[0];

                                    $json = file_get_contents("http://ddragon.leagueoflegends.com/cdn/" . $currentVersion . "/data/en_US/item.json");
                                    $array = json_decode($json, true);
                                    $items = $array["data"];

                                    for ($i=1; $i < $anzahlSets + 1; $i++) { 
                                        echo "<div class='sets setContainer" . $i . "'>
                                            <p class='setNumber'>Set " . $i . "</p>
                                            <hr>
                                            <label for='set" . $i ."'> Set Title
                                                <input type='text' name='set" . $i . "' id='set" . $i . "' value='" . $derBuild["set" . $i] . "'>
                                            </label>
                                            <div class='setContainer'>";

                                                for ($x=1; $x < 11; $x++) {
                                                    if ( $derBuild["Set" . $i ."item" . $x] != null ) {
                                                        echo "<div class='itemContainer'>
                                                                <img src='../img/symbols/items/" . substr($derBuild['Set' . $i .'item' . $x], 8) . ".png' alt='Picture of the Item " . $items[substr($derBuild['Set' . $i .'item' . $x], 8)]["name"] . "' data-cost='" . $items[substr($derBuild['Set' . $i .'item' . $x], 8)]["gold"]["base"] . "' data-name='" . substr($derBuild['Set' . $i .'item' . $x], 8) . "'>
                                                                <input type='hidden' name='Set" . $i . "item" . $x . "' value='Set" . $i . "item" . substr($derBuild['Set' . $i .'item' . $x], 8) . "'>
                                                            </div>";
                                                    }
                                                };

                                        echo "</div>
                                        <i class='far fa-trash-alt trash" . $i . "'></i>
                                        </div>";
                                    }

                                } ?>
                                
                            </div>                            

                            

                        </div>
                        <div class="items">
                            <div class="itemsFilter">
                                 <ul>
                                     <li class="active" id="All">ALL</li>
                                     <li id="Jungle">Jungle</li>
                                     <li id="Lane">Lane</li>
                                     <li id="Damage">Damage</li>
                                     <li id="SpellDamage">Ability Power</li>
                                     <li id="Armor">Armor</li>
                                     <li id="SpellBlock">Magic Resist</li>
                                     <li id="Health">Health</li>
                                     <li id="Boots">Boots</li>
                                 </ul>
                            </div>
                            <div class="itemsInhalt">
                                <div class="itemInfos">
                                    <div class="itemInfosHeader">
                                        <img>
                                        <p class="itemName"></p>
                                        <p class="itemCost"></p>
                                        <p class="itemSell"></p>
                                    </div>
                                    <div class="itemInfosBottom">

                                    </div>
                                    
                                    <div class="addToSetWrapper">
                                        <p class="addToSetButton">Create a set first</p>
                                    </div>
                                    

                                </div>

                                <div class="allItems">
                                    
                                </div>
                            
                            </div>
                       
                        </div>
                   
                    </div>

                </div>

                <!-- Add to Set menu -->

                <div class="addToSetBG">
                    <ul>
                        <h2>Wähle dein Set aus</h2>

                            <?php if ($editMode == true && $buildVorhanden == true ) {
                            
                                for ($i=1; $i < $anzahlSets + 1; $i++) {
                                    echo "<li class='liSet" . $i . "'>Set " . $i . "</li>";
                                }

                            }

                            ?>

                    </ul>
                </div>

                <p class="createGuideP">Ability maxing order:</p>

                <div class="abilityMaxingOrder">

                    <div class="abilityMaxingOrderContainer">

                        <p>I</p>
                        
                        <div class="abilityContainer1">

                            <label>
                                <input type="radio" class="abilityMaxing1" name="abilityMaxing1" value="Q" checked>
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=Q" alt="Image of the Q Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing1" name="abilityMaxing1" value="W">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=W" alt="Image of the W Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing1" name="abilityMaxing1" value="E">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=E" alt="Image of the E Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing1" name="abilityMaxing1" value="R">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=R" alt="Image of the R Ability"></div>
                            </label>

                        </div>

                    </div>

                    <div class="abilityMaxingOrderContainer">

                        <p>II</p>
                        
                        <div class="abilityContainer2">

                            <label>
                                <input type="radio" class="abilityMaxing2" name="abilityMaxing2" value="Q">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=Q" alt="Image of the Q Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing2" name="abilityMaxing2" value="W" checked>
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=W" alt="Image of the W Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing2" name="abilityMaxing2" value="E">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=E" alt="Image of the E Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing2" name="abilityMaxing2" value="R">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=R" alt="Image of the R Ability"></div>
                            </label>

                        </div>

                    </div>

                    <div class="abilityMaxingOrderContainer">

                        <p>III</p>
                        
                        <div class="abilityContainer3">

                            <label>
                                <input type="radio" class="abilityMaxing3" name="abilityMaxing3" value="Q">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=Q" alt="Image of the Q Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing3" name="abilityMaxing3" value="W">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=W" alt="Image of the W Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing3" name="abilityMaxing3" value="E" checked>
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=E" alt="Image of the E Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing3" name="abilityMaxing3" value="R">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=R" alt="Image of the R Ability"></div>
                            </label>

                        </div>

                    </div>

                    <div class="abilityMaxingOrderContainer">

                        <p>IV</p>
                        
                        <div class="abilityContainer4">

                            <label>
                                <input type="radio" class="abilityMaxing4" name="abilityMaxing4" value="Q">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=Q" alt="Image of the Q Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing4" name="abilityMaxing4" value="W">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=W" alt="Image of the W Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing4" name="abilityMaxing4" value="E">
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=E" alt="Image of the E Ability"></div>
                            </label>

                            <label>
                                <input type="radio" class="abilityMaxing4" name="abilityMaxing4" value="R" checked>
                                <div class="abilityIcon"> <img src="https://via.placeholder.com/64x64?text=R" alt="Image of the R Ability"></div>
                            </label>

                        </div>

                    </div>

                </div>

                <div class="textInhalt">

                    <p class="createGuideP">Inhalt:</p>

                    <textarea name="editor1" id="editor1" rows="10" cols="80">
                        <?=$editor1?>
                    </textarea>
                        
                </div>

                <?php 
                    // Prüfen ob man den Guide editiert oder erstellt
                    if ( $editMode == true ) {
                        echo "<input type='hidden' name='guideID' value='" . $_GET["guide"] . "'>";
                        echo "<input type='submit' name='Update' value='Update'>";
                    } else {
                        echo "<input type='submit' name='Erstellen' value='Erstellen'>";
                    }
                ?>
                
            </form>

        </div>

    </section>

    <!-- Footer -->

    <footer>
        <img src="../img/logo/Logosmall.png" alt="Picture of my Logo">
        <p>&copy; COPYRIGHT Damir Mavric</p>
    </footer>

    <!-- SCRIPTS -->

    <script src="../js/jquery.js"></script>
    <script src="../jquery-ui/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
    <script src="../js/toggleNav.js"></script>
    <script src="../js/changeRuneContainer.js"></script>
    <script src="../js/changeAbilityIcons.js"></script>
    <script src="../js/itemBuild.js"></script>
    <script src="../js/feedback.js"></script>
    <script>
        CKEDITOR.replace( 'editor1',{
            customConfig: 'config.js'
        } );
    </script>
    <script src="../js/createGuideValidierung.js"></script>
    <?php 
        if ($editMode == true) {
            echo "<script src='../js/changeAbilityIconsEditMode.js'></script>";
            echo "<script src='../js/editItemBuild.js'></script>";
        }
    ?>
    
</body>

</html>