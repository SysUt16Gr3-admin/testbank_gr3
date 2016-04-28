<?php

session_start();

header("Location: velgFil.php?vers=".$_SESSION['selectedVersion']);
exit;