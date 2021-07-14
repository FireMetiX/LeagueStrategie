<?php
    // Session Cookie Name (Key) umbenennen: gegen Hijacking / Spyware
    if( session_name() != 'MeineSessionID'){
        session_name('MeineSessionID');
    }

    // Session starten
    session_start();
    session_regenerate_id();
?>