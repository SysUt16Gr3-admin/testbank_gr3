<?php 

session_start();
//session_unset();


header('Location: velgVersjon.php?valgtFag='. $_SESSION["selectedSubject"]);
exit;