<?php // Zeigt die Neusten User an
    if($users != "NoUsers"){
        foreach( $users as $user ) {
            echo "<div class='user'>";
            echo "<div class='userinfo'><p class='username'>" . $user["username"] . "</p></div>";
            echo "<div class='useremail'><p class='email'>" . $user["email"] . "</p></div>";
            echo "<div class='userdate'><p class='date'>created in " . $user["created"] . "</p></div>";
            echo "</div>";

            echo "<div class='usereditContainer'><div class='userDelete' data-userid='" . $user["ID"] . "'><i class='far fa-trash-alt'></i></div></div>";
        }
    } else {
        echo "<div class='displayerrors'>"; 
            echo "<p>Keine User vorhanden!</p>";
        echo "</div>";
    }

?>