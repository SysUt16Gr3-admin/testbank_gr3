<?php
session_start ();

$_SESSION ["selectedFile"] = $_POST ['fileSelection'];
echo str_repeat ( '<br/>', 2 );
echo '<p style="color:blue; font-size:20"><b>Info om filen:</b></p>';

if (isset ( $_POST ['fileSelection'] )) {
	echo '<span style="padding-left:10px">Fag:&nbsp;</span>' . '<b>' . $_SESSION ["selectedSubject"] . '</b><br/>';
	echo '<span style="padding-left:10px">Versjon:&nbsp;</span>' . '<b>' . $_SESSION ["selectedVersion"] . '</b><br/>';
	echo '<span style="padding-left:10px">Filnavn:&nbsp;</span>' . '<b>' . $_SESSION ["selectedFile"] . '</b><br/>';
	$filename = $_SESSION ['selectedFile'];
	$file = getcwd () . '/Subject/' . $_SESSION ['selectedSubject'] . '/' . $_SESSION ["selectedVersion"] . '/' . $filename;
	$fileContents = file_get_contents ( $file );
	echo '<br/>';
	echo '<form action="lagreRedigertFil.php" method="post">';
	echo '<span style="padding-left:10px">Sp&oslash;rsm&aring;l:</span><textarea name="question" rows="10" cols="60">';
	?><?php

	
echo htmlentities ( $fileContents, ENT_QUOTES, 'UTF-8' );
	?>
	  <?php
	echo '</textarea>';
	echo '<br/><br/>';
	echo '<span style="padding-left:10px">Lagre i fag:</span>';
	echo '<span style="padding-left:10px"><input type="text" name="Fag" value="' . $_SESSION ["selectedSubject"] . '" maxlength="50"></span>';
	echo '<br/><br/>';
	echo '<span style="padding-left:10px">Lagre i versjon:</span>';
	echo '<span style="padding-left:10px"><input type="text" name="Versjon" value="' . $_SESSION ["selectedVersion"] . '" maxlength="15"></span>';
	echo '<br/>';
	echo '<p><span style="padding-left:10px">Filnavn kommer til &aring; se slik ut: <b>spoersmaal_16-01-01 00-00-00.txt</b>. Du kan bare endre delen <b><i>spoersmaal</i></b> i filnavn feltet.</span></p>';
	echo '<span style="padding-left:10px"><input type="text" name="filName" placeholder="&lt;filnavn&gt;" maxlength="15"></span>';
	echo '<br/><br/>';
	echo '<span style="padding-left:10px"><input type="submit" name="lagreFil" value="Lagre"></span>';
	echo str_repeat ( '&nbsp;', 10 );
	echo '<button type="reset" value="Reset">Clear</button>';
	echo '</form>';
}

echo str_repeat ( '</br>', 1 );

echo '<html>';
echo '<body>';
echo '<form action="QuestionEdit.php" method="post">';
echo str_repeat ( '<br/>', 4 );
echo '<span style="padding-left:10px"><input type="submit" name="submitHome" value="Hjem"></span>';
echo str_repeat ( '&nbsp', 15 );
echo '<input class="btnTilbake" formaction="bakTovelgFil.php" type="submit" name="submitTilbake" value="Tilbake">';
echo '</form>';
echo '</body>';
echo '</html>';