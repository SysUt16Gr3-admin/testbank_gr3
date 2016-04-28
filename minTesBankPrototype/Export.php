<?php
if ($_POST ['submito'] && $_POST ['submito'] != '') {
	
	$file = $_POST ['zipFiles'];
	$myFile = getcwd () . '/ZipFolder/' . $file;
	
	if (file_exists ( $myFile ) && preg_match ( '/(zip)/', $myFile )) {
		downloadFile ( $myFile );
	} else {
		echo 'Select a file with zip-extension';
	}
}
function downloadFile($myFile) {
	header ( 'Content-Description: File Transfer' );
	header ( 'Content-Type: application/octet-stream' );
	header ( 'Content-Disposition: attachment; filename=' . basename ( $myFile ) );
	header ( 'Expires: 0' );
	header ( 'Cache-Control: must-revalidate' );
	header ( 'Pragma: public' );
	header ( 'Content-Length: ' . filesize ( $myFile ) );
	ob_clean ();
	flush ();
	readfile ( $myFile );
	exit ();
}




