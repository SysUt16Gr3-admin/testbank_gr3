<?php

session_start();
//session_unset();


header('Location: ChooseVersion.php?valgtFag='. $_SESSION["selectedSubject"]);
exit;