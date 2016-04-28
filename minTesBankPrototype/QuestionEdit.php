<html>
<body>

	<div>
		<br>
		<br> <span style="padding-left: 20px; color: blue;"><b>Vis/Rediger
				sp&oslash;rsm&aring;l</b></span>
		<form action="VelgFag.php" method="post">
			<br /> <span style="padding-left: 20px"><input type="submit"
				value="Hent sp&oslash;rsm&aring;l"></span>
		</form>
	</div>
	<br />
	
	<div>
		<p>
			<span style="padding-left: 10px; color: blue;"><b>Skriv
					sp&oslash;rsm&aring;l</b></span>
		</p>
		<form action="UploadQuestionFromEdit.php" method="post">
			<textarea name="questionEditor" rows="10" cols="100"
				placeholder="Skriv her..." maxlength="200">
			</textarea>
			<br />
			<br /> <input type="text" name="newSubject" placeholder="&lt;Fag&gt;"
				maxlength="50"> <br />
			<br /> <input type="text" name="newVersion"
				placeholder="&lt;versjon&gt;" maxlength="5"> <br />
			<p>
				Filnavn kommer til &aring; se slik ut: <b>spoersmaal_16-01-01
					00-00-00.txt</b>. Du kan bare endre delen <b><i>spoersmaal</i></b>
				i filnavn feltet.
			</p>
			<input type="text" name="fileName" placeholder="&lt;filnavn&gt;"
				maxlength="5"> <br />
			<br /> <input type="submit" value="Lagre">
				<?php echo str_repeat('&nbsp;', 8); ?>
				<button type="reset" value="Reset">Clear</button>
		</form>
	</div>

	<form action="ReturnToHTMLIndex.php" method="post">
		<?php echo str_repeat('<br/>', 4); ?>
		<input type="submit" name="submitHome" value="Tilbake">

	</form>

</body>
</html>


