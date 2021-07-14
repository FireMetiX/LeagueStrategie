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

    include_once("../includes/guidesListingData.php");

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
    <link rel="stylesheet" href="../css/style_guides.css">
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

        <section class="guides">

            <h1 class="guidesTitle">Starte deine steigung!</h1>

            <div class="guidesContainer">
                
                <div class="guidesFilter">

                    <form method="GET">

                        <div class="guidesLanes">

                            <p>Lane:</p>

                            <div class="lanes">

                                <label>
                                    <input type="radio" name="role" value="all" checked>
                                    <div class="lane"> All</div>
                                </label>

                                <label>
                                    <input type="radio" name="role" value="top">
                                    <div class="lane"> Top</div>
                                </label>

                                <label>
                                    <input type="radio" name="role" value="jungle">
                                    <div class="lane"> Jungle</div>
                                </label>

                                <label>
                                    <input type="radio" name="role" value="Mid">
                                    <div class="lane"> Mid</div>
                                </label>

                                <label>
                                    <input type="radio" name="role" value="Bot">
                                    <div class="lane"> Bot</div>
                                </label>

                                <label>
                                    <input type="radio" name="role" value="Support">
                                    <div class="lane"> Support</div>
                                </label>

                            </div>

                        </div>

                        <div class="guidesChampions">

                            <p>Champion:</p>

                            <label class="championSelection" for="championSelection">
                                <select id="championSelect" name="championSelection">
                                    <option value="0">Choose a Champion...</option>
                                    <?php
                                    // Get Champion data from json file
                                    $myJsonFile = file_get_contents("../json/champion.json");
                                    $array = json_decode($myJsonFile, true);
                                    $championarray = $array["data"];

                                    // var_dump($championarray["Aatrox"]);

                                    // Making Selection of every Champion
                                    foreach($championarray as $champion){ ?>
                                        <option value=<?php echo $champion["id"] ?>><?php echo $champion["name"] ?></option>
                                    <?php } ?>

                                </select>

                            </label>

                            <input type="hidden" name="page" value="1">

                            </div>

                            <div class="filtern">
                            <a href="guides"><button>Filter</button></a>
                            </div>

                    </form>

                </div>

                <hr>

                <div class="guidesInhalt">

                    <?php 
                        // Hier werden die Guides Aufgelistet
                        include_once("../includes/guidesChampionlisting.php");
                        // Page Selection wird included
                        include_once("../includes/guidesPageSelection.php");
                    ?>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
    <script src="../js/toggleNav.js"></script>
    <script src="../js/feedback.js"></script>
    <script src="../js/deleteGuide.js"></script>
    
</body>

</html>