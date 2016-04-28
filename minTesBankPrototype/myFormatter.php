<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>pr&oslash;ve-visning</title>
<style>
h1, h2 {
	font-size: medium;
}
</style>
</head>
<body bgcolor="EEEEEE">


<?php
$opplastetFil = $_FILES ['uploadFileTest'] ['name'];
$opplasting_filSti = getcwd () . '/';
$opplasting_file = $opplasting_filSti . basename ( $_FILES ['uploadFileTest'] ['name'] );
$fileType = pathinfo ( $opplastetFil, PATHINFO_EXTENSION );

?>

	<h2>
		<b>Info om fil:</b>
	</h2>

<?php

if (isset ( $opplastetFil ) && $opplastetFil !== '') {
	print "Valgt zip-fil: " . "<font color='blue'>$opplastetFil</font>" . '<br>' . '<br>';
	
	if ($fileType == 'zip') {
		$subjectDir = 'ZipFolder';
		if (! file_exists ( getcwd () . '/' . $subjectDir )) {
			mkdir ( getcwd () . '/' . $subjectDir, 0777, true );
		}
		$opplasting_folder = getcwd () . '/' . $subjectDir . '/' . basename ( $opplastetFil );
		if (move_uploaded_file ( $_FILES ['uploadFileTest'] ['tmp_name'], $opplasting_folder )) {
			echo 'Fil: ' . "<font color='blue'>$opplastetFil</font>" . ' har blitt lastet opp.' . '<br>' . '<br>';
			unzip ( $opplasting_folder );
		} else {
			echo 'moving failed';
		}
	} else if ($fileType == 'txt') {
		$textFolder = 'TxtFolder';
		if (! file_exists ( getcwd () . '/' . $textFolder )) {
			mkdir ( getcwd () . '/' . $textFolder, 0777, true );
		}
		$opplasting_folder = getcwd () . '/' . $textFolder . '/' . basename ( $opplastetFil );
		if (move_uploaded_file ( $_FILES ['uploadFileTest'] ['tmp_name'], $opplasting_folder )) {
			echo 'Fil: ' . "<font color='blue'>$opplastetFil</font>" . ' har blitt lastet opp.' . '<br>' . '<br>';
			echo "<br/>Displaying contents... > <br/><br/>";
			echo "<font color='green' size='4'><p><b><i>" . file_get_contents ( $opplasting_folder ) . "</i></b></p></font>";
		} else {
			echo 'moving failed';
		}
	}
} else {
	echo "<font color='red'>No file was chosen before submitting</font>";
}
function unzip($zip_fil) {
	$minFilSti = glob ( $zip_fil );
	$stiUtpakking = getcwd () . '/ZipFolder/' . date ( "ymd" ) . '/';
	foreach ( $minFilSti as $minFil ) {
		$zip = new ZipArchive ();
		if ($zip->open ( $minFil ) === true) {
			$zip->extractTo ( $stiUtpakking );
			
			$zip->close ();
			
			moveManifest ();
			
			?>

	<h2>
		<b>Visning av sp&oslash;rsm&aring;l og svar:</b>
	</h2>
	
<?php
			leseXML ();
		} else {
			echo '<span style="color:red";>Filen er IKKE pakket ut!</span>';
		}
	}
}
function moveManifest() {
	$ManifestDir = 'Manifest_Folder';
	if (! file_exists ( getcwd () . '/' . $ManifestDir )) {
		mkdir ( getcwd () . '/' . $ManifestDir, 0777, true );
	}
	$files = glob ( "ZipFolder/" . date ( "ymd" ) . "/ims*.xml" );
	foreach ( $files as $file ) {
		$to = str_replace ( "ZipFolder/" . date ( "ymd" ) . "/", "Manifest_folder/", $file );
		rename ( $file, $to );
	}
}
function leseXML() {
	$minXMLFil = glob ( getcwd () . '/ZipFolder/' . date ( "ymd" ) . '/item*.xml' );
	$minNyXMLFil = getcwd () . '/ZipFolder/' . date ( "ymd" ) . '/item';
	
	$i = 1;
	foreach ( $minXMLFil as $value ) {
		while ( file_exists ( "{$minNyXMLFil}{$i}.xml" ) )
			$i ++;
		copy ( $value, "{$minNyXMLFil}{$i}.xml" );
		
		$doc = new DOMDocument ();
		$doc->load ( "{$minNyXMLFil}{$i}.xml" );
		
		$questions = $doc->getElementsByTagName ( "itemBody" );
		foreach ( $questions as $question ) {
			$spørsmål = $question->childNodes->item ( 0 )->nodeValue;
			createtxtFile ( $spørsmål );
		}
		
		echo "$i)" . '&nbsp;' . '<span style="color:blue";>Sp&oslashrsm&aringl:</span>' . '<br>' . $spørsmål . "<br>" . "<br>";
		
		$answers = $doc->getElementsByTagName ( "simpleChoice" );
		$arr = iterator_to_array ( $answers );
		echo '<span style="color:green";>Svar:</span>' . '<br>';
		foreach ( $arr as $value ) {
			echo $value->textContent . '<br>';
		}
		$correctAnswer = $doc->getElementsByTagName ( "correctResponse" );
		$arr = iterator_to_array ( $correctAnswer );
		echo '<span style="color:green";><b>Riktig svar:</b></span>' . '<br>';
		foreach ( $arr as $value ) {
			echo $value->textContent . '<br>';
		}
		echo '<br>';
	}
	
	slettFiler ();
}
function createtxtFile($fileContent) {
	// $i = 1;
	$filename = getcwd () . '/TxtFolder/spørsmål.txt';
	$file = fopen ( $filename, "w" ) or die ( "Unable to open file!" );
	fwrite ( $file, $fileContent );
	
	fclose ( $file );
}
function slettFiler() {
	slettfolder ( 'ZipFolder/' . date ( "ymd" ) );
	slettItemFiler ();
}
function slettfolder($folder) {
	foreach ( scandir ( $folder ) as $fil ) {
		if ('.' === $fil || '..' === $fil)
			continue;
		if (is_dir ( "$folder/$fil" ))
			rmdir_recursive ( "$folder/$fil" );
		else
			unlink ( "$folder/$fil" );
	}
	rmdir ( $folder );
}
function slettItemFiler() {
	$minFil = 'item*.xml';
	array_map ( 'unlink', glob ( '/ZipFolder/' . date ( "ymd" ) . '/' . $minFil ) );
}

?>
</body>
</html>





