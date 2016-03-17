<?php
require_once 'Manifest.php';

$manifest = new Manifest("./Resources");
$manifest->setManifestElement();
$manifest->displayManifest();
$manifest->addResourceToManifest("item");