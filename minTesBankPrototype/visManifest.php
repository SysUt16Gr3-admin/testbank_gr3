<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>pr&oslash;ve-visning</title>
<style>
h1, h2 {
	font-size: large;
}
</style>
</head>
<body bgcolor="EEEEEE">

	<h1>Parsing av Manifest fila:</h1>


<?php
require_once 'ManifestParser.class.php';

if ($_POST ['send'] && $_POST ['send'] != '') {
	
	$xml = new ManifestParser ();
	$manifestFila = getcwd () . '/Manifest_Folder/imsmanifest.xml';
	if (! file_exists ( $manifestFila )) {
		echo 'Du m&aring f&oslashrst eksportere sp&oslashrsm&aringl/test fra itsLearning';
	} else {
		$output = $xml->parse ( $manifestFila );
		print_r ( $output );
		
		?>
		<br>
	<h1>
		Les mer om ims-manifest:<a
			href="http://www.scormsoft.com/scorm/cam/manifestFiles">her</a>
	</h1>
	<p>&nbsp;&nbsp;&lt;manifest&gt; attributer(attributes):</p>
		
		<?php
		echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;identifier:&nbsp;' . '<span style="color:blue";>' . $output [0] ['attrs'] ['IDENTIFIER'] . '</span>';
		?>
		<p>&nbsp;&nbsp;&lt;manifest&gt; elements:</p>	
		<?php
		echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>metadata:&nbsp;</b>';
		?>
		<ul>
		<li>schema:&nbsp;<?php echo '<span style="color:blue";>'.$output[0]['child'][0]['child'][0]['content'].'</span>'; ?></li>
	</ul>
	<ul>
		<li>schemaversion:&nbsp;<?php echo '<span style="color:blue";>'.$output[0]['child'][0]['child'][1]['content'].'</span>'; ?></li>
	</ul>
		<?php
		echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>organizations:&nbsp;</b>';
		echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>resources:&nbsp;</b>';
		?>
		<ul>
		<li>identifier(s):&nbsp;
			<?php
		$arr_Resources_Id = $output [0] ['child'] [2] ['child'];
		for($i = 0; $i < count ( $arr_Resources_Id ); $i ++) {
			echo '<span style="color:blue";>' . $output [0] ['child'] [2] ['child'] [$i] ['attrs'] ['IDENTIFIER'] . '-' . '</span>';
		}
		?>
			</li>
	</ul>
	<ul>
		<li>type(s):&nbsp;
			<?php
		$arr_Resources_Type = $output [0] ['child'] [2] ['child'];
		for($i = 0; $i < count ( $arr_Resources_Type ); $i ++) {
			echo '<span style="color:blue";>' . $output [0] ['child'] [2] ['child'] [$i] ['attrs'] ['TYPE'] . '-' . '</span>';
		}
		?>
			</li>
	</ul>
	<ul>
		<li>href(s):&nbsp;
			<?php
		$arr_Resources_Href = $output [0] ['child'] [2] ['child'];
		for($i = 0; $i < count ( $arr_Resources_Href ); $i ++) {
			echo '<span style="color:blue";>' . $output [0] ['child'] [2] ['child'] [$i] ['attrs'] ['HREF'] . '-' . '</span>';
		}
		?>
			</li>
	</ul>
		
		<?php
		echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>file(s):&nbsp;</b>';
		?>
		<ul>
		<li>href(s):&nbsp;
			<?php
		$arr_Files = $output [0] ['child'] [2] ['child'];
		for($i = 0; $i < count ( $arr_Files ); $i ++) {
			echo '<span style="color:blue";>' . $output [0] ['child'] [2] ['child'] [$i] ['child'] [1] ['attrs'] ['HREF'] . '-' . '</span>';
		}
		?></li>
	</ul>
		
		<?php
	}
} else {
	echo 'Du må først eksportere spørsmål/test fra itsLearning';
}

?>

</body>
</html>