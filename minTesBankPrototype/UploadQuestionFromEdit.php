<?php
$questionText = htmlentities ( $_POST ["questionEditor"] );
$questionSubject = htmlentities ( $_POST ["newSubject"] );
$questionVersion = htmlentities ( $_POST ["newVersion"] );
$fileName = htmlentities ( $_POST ['fileName'] );

if ($questionText == '' || $questionSubject == '' || $questionVersion == '') {
	echo '<span style="color:red">Feltene med tekst, fag og versjon m&aring; fylles ut f&oslash;rst</span>';
} else {
	if (! file_exists ( 'Subject/' . $questionSubject )) {
		mkdir ( 'Subject/' . $questionSubject . '/' );
		mkdir ( 'Subject/' . $questionSubject . '/' . $questionVersion );
		
		if ($fileName == '') {
			$filnavn = 'Subject/' . $questionSubject . '/' . $questionVersion . '/' . 'spoersmaal' . '_' . date ( 'y-m-d h-i-s' ) . '.txt';
			if (file_put_contents ( $filnavn, $questionText ) !== FALSE) {
				echo 'Filen ' . '<b>' . $filnavn . '</b>' . ' har blitt lagret.';
			} else {
				echo 'Feil ved å lagre ' . '<b>' . $filnavn . '</b>' . ' !';
			}
		} else {
			$filnavn = 'Subject/' . $questionSubject . '/' . $questionVersion . '/' . $fileName . '_' . date ( 'y-m-d h-i-s' ) . '.txt';
			if (file_put_contents ( $filnavn, $questionText ) !== FALSE) {
				echo 'Filen ' . '<b>' . $filnavn . '</b>' . ' har blitt lagret.';
			} else {
				echo 'Feil ved å lagre ' . '<b>' . $filnavn . '</b>' . ' !';
			}
		}
	} else {
		if ($fileName == '') {
			$filnavn = 'Subject/' . $questionSubject . '/' . $questionVersion . '/' . 'spoersmaal' . '_' . date ( 'y-m-d h-i-s' ) . '.txt';
			if (file_put_contents ( $filnavn, $questionText ) !== FALSE) {
				echo 'Filen ' . '<b>' . $filnavn . '</b>' . ' har blitt lagret.';
			} else {
				echo 'Feil ved å lagre ' . '<b>' . $filnavn . '</b>' . ' !';
			}
		} else {
			$filnavn = 'Subject/' . $questionSubject . '/' . $questionVersion . '/' . $fileName . '_' . date ( 'y-m-d h-i-s' ) . '.txt';
			if (file_put_contents ( $filnavn, $questionText ) !== FALSE) {
				echo 'Filen ' . '<b>' . $filnavn . '</b>' . ' har blitt lagret.';
			} else {
				echo 'Feil ved å lagre ' . '<b>' . $filnavn . '</b>' . ' !';
			}
		}
	}
}

echo '<html>';
echo '<body>';
echo '<form action="QuestionEdit.php" method="post">';
echo str_repeat ( '<br/>', 4 );
echo '<span style="padding-left:10px"><input type="submit" name="submitHome" value="Tilbake"></span>';
echo '</form>';
echo '</body>';
echo '</html>';	
	
	
