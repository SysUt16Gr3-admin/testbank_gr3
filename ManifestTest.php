<?php
require_once 'C:\xampp\htdocs\testbank_gr3\IMS_QTI_Manifest.php';

$manifest = new IMS_QTI_Manifest("Test1");
$manifest->createManifestBaseElements();
$manifest->addResourceToManifest("item");
$manifest->displayManifest();
$manifest->saveManifestToFile();