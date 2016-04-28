<?php

session_start();

if (!isset($_POST['subjectSelection'])) {
	
	$string = htmlentities($_GET['valgtFag']);
	if ($string[0] === 'C') {
		$_POST['versionSelection'] = substr_replace($string, '++',1, 2);
		
		$_SESSION["versionDir"] = 'Subject/' . $_SESSION["selectedSubject"] . '/';
		$versionFolders = scandir($_SESSION["versionDir"]);
		
		echo 'Valgt fag: ' .'<b>'. $_SESSION["selectedSubject"] . '<br/><br/><br/></b>';
		
		echo '<form action="velgFil.php" method="post">';
		echo 'Velg versjon av '. $_SESSION["selectedSubject"] . ':';
		echo str_repeat('</br>', 2);
		echo '<select name="versionSelection">';
		for($i = $_SESSION["startIndex"]; $i < sizeof($versionFolders); $i++) {
			echo 	'<option value="' . $versionFolders[$i] . '">'
					. $versionFolders[$i]
					. '</option>';
		}
		echo '</select>';
		echo '<input type="submit" name="submitVersion" value="Velg">';
		echo '</form>';
		
	} else {
		
		$_SESSION["selectedSubject"] = htmlentities($_GET['valgtFag']);
		$_SESSION["versionDir"] = 'Subject/' . $_SESSION["selectedSubject"] . '/';
		$versionFolders = scandir($_SESSION["versionDir"]);
		
		echo 'Valgt fag: ' .'<b>'. $_SESSION["selectedSubject"] . '<br/><br/><br/></b>';
		
		echo '<form action="velgFil.php" method="post">';
		echo 'Velg versjon av '. $_SESSION["selectedSubject"] . ':';
		echo str_repeat('</br>', 2);
		echo '<select name="versionSelection">';
		for($i = $_SESSION["startIndex"]; $i < sizeof($versionFolders); $i++) {
			echo 	'<option value="' . $versionFolders[$i] . '">'
					. $versionFolders[$i]
					. '</option>';
		}
		echo '</select>';
		echo '<input type="submit" name="submitVersion" value="Velg">';
		echo '</form>';
	}
	
	
} else {
	$_SESSION["selectedSubject"] = $_POST["subjectSelection"]; //Faget som ble valgt
	$_SESSION["versionDir"] = 'Subject/' . $_SESSION["selectedSubject"] . '/';
	$versionFolders = scandir($_SESSION["versionDir"]);
	
	echo 'Valgt fag: ' .'<b>'. $_SESSION["selectedSubject"] . '<br/><br/><br/></b>';
	
	echo '<form action="velgFil.php" method="post">';
	echo 'Velg versjon av '. $_SESSION["selectedSubject"] . ':';
	echo str_repeat('</br>', 2);
	echo '<select name="versionSelection">';
	for($i = $_SESSION["startIndex"]; $i < sizeof($versionFolders); $i++) {
		echo 	'<option value="' . $versionFolders[$i] . '">'
				. $versionFolders[$i]
				. '</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="submitVersion" value="Velg">';
	echo '</form>';
}

?>

<html>
<body>
<form action="QuestionEdit.php" method="post">
<br/><br/><br/><br/><br/><br/><br/>
<input type="submit" name="submitHome" value="Hjem">
<?php echo str_repeat('&nbsp', 15); ?>
<input class="btnTilbake" formaction="bakTovelgFag.php" type="submit" name="submitTilbake" value="Tilbake">
</form>
</body>
</html>
