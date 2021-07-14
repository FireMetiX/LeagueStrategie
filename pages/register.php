<?php 
    include_once("../includes/functions.inc.php");
    include_once("../includes/credentials.php");
    include_once("../class/pdoconn.class.php");

    // Session Cookie Name (Key) umbenennen: gegen Hijacking / Spyware
    include_once("../includes/sessionData.php");

    // Verbindung mit Datenbank herstellen
    $instanz = new Dbh($host, $user, $pass, $dbname);

    // Prüft Session Informationen und weist welche zu.
    include_once("../includes/userInformationCheck.php");

    // Prüfen, ob auf Submit geklickt wurde
    if (isset($_POST["submit"])) {
        
        // Values speichern und desinfizieren
        $nachname = desinfect($_POST["nachname"]);
        $vorname = desinfect($_POST["vorname"]);
        $username = desinfect($_POST["username"]);
        $passwort = desinfect($_POST["password"]);
        $email = desinfectEmail($_POST["email"]);

        // Passwort Hashen
        $hashPassword = password_hash($passwort,PASSWORD_DEFAULT);

        $instanz->register($nachname, $vorname, $username, $hashPassword, $email, 0);

    }
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
    <link rel="stylesheet" href="../css/style_register.css">
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

        <section class="register">

            <div class="registerContainer">

                <h1>Registrieren</h1>

                <hr>

                <form method="POST">

                    <label for="nachname">
                        <p>Nachname</p>
                        <input type="text" name="nachname" id="nachname">
                    </label>

                    <label for="vorname">
                        <p>Vorname</p>
                        <input type="text" name="vorname" id="vorname">
                    </label>

                    <label for="username">
                        <p>Username</p>
                        <input type="text" name="username" id="username">
                    </label>

                    <label for="password">
                        <p>Passwort</p>
                        <input type="password" name="password" id="password">
                    </label>

                    <label for="email">
                        <p>Email</p>
                        <input type="text" name="email" id="email">
                    </label>

                    <button id="submit" name="submit">Registrieren</button>

                </form>

            </div>

            <?php 
            
                global $error;

                if ($error == true) {
                        echo "<div class='displayerrors'>"; 
                        foreach($errors as $error){
                            echo "<p>" . $error . "</p>";
                        }
                        echo "</div>";
                    } else {

                } 
            ?>

        </section>

    </section>

    <!-- Footer -->

    <footer>
        <img src="../img/logo/Logosmall.png" alt="Picture of my Logo">
        <p>&copy; COPYRIGHT Damir Mavric</p>
    </footer>

    <!-- SCRIPTS -->

    <script src="../js/toggleNav.js"></script>
    <script src="../js/displayInfo.js"></script>
    <script src="../js/registerValidierung.js"></script>

</body>

</html>