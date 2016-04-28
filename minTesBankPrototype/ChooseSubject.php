<?php
session_start ();

$subjectDir = 'Subject';

if (! file_exists ( getcwd () . '/' . $subjectDir )) {
	mkdir ( getcwd () . '/' . $subjectDir, 0777, true );
}

$subjectFolders = scandir ( $subjectDir );
$_SESSION ["startIndex"] = 2;

echo 'Velg fag:<br/><br/>';
echo '<form action="ChooseVersion.php" method="post">';
echo '<select name="subjectSelection">';
for($i = $_SESSION ["startIndex"]; $i < sizeof ( $subjectFolders ); $i ++) {
	echo '<option value="' . $subjectFolders [$i] . '">' . $subjectFolders [$i] . '</option>';
}
echo '</select>';
echo '<input type="submit" name="submitSubject" value="Velg">';
echo '</form>';

?>

<html>
<body>
	<form action="ReturnToHTMLIndex.php" method="post">
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br /> <input type="submit" name="submitHome" value="Tilbake">
	</form>
</body>
</html>
