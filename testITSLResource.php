<?php

require_once("ITSLResourceEitherOr.php");

$ITSLEitherOr = new ITSLResourceEitherOr();

/** Builds ITSLResourceEitherOr with arguments: question, responseID1, responseID2, responseText1, responseText2, shuffle, maxChoices, minChoices
 *  Saves resource to $filename . 'xml'.
 * */
$ITSLEitherOr->buildResource("Er dette et enten eller spørsmål?", "A0", "A1", "Ja", "Nei", "A0", "false", "1", "0");
$ITSLEitherOr->saveResource("itemEitherOr");

?>