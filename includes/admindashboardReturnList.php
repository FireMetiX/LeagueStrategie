<?php

    include_once("../includes/credentials.php");
    include_once("../class/pdoconn.class.php");

    session_start();

    $instanz = new Dbh($host, $user, $pass, $dbname);
    $guides = $instanz->showNewestGuides(); // Zeigt die neusten 3 Guides an
    $users = $instanz->showNewestUsers(); // Zeigt die neusten 3 User an

?>

<section class="admin">

            <h1>Admin Dashboard</h1>

            <div class="adminContainer">

                <div class="latestGuidesContainer">

                    <h2>Neusten Guides</h2>

                    <?php 
                        // 3 Neusten Guides werden aufgelistet
                        include_once("../includes/admindashboardChampionlisting.php");
                    ?>

                    <a href="guides"><p class="latestGuidesToTheGuides">Zu den Guides</p></a>

                </div>

                <div class="latestRegistrationsContainer">

                    <h2>Neuste Registrierungen</h2>

                    <?php
                        // 3 Neusten User werden aufgelistet
                       include_once("../includes/admindashboardUserslisting.php");
                    ?>

                </div>

            </div>

        </section>