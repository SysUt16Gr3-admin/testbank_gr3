<?php

/**
 * Created by PhpStorm.
 * User: petersc
 * Date: 19.03.2016
 * Time: 11:51
 */
abstract class Manifest {
    protected $baseTestDirectory = "./TestResources";   // Base directory for all tests
    protected $resourceTemplatesDirectory = "./XML_Templates"; // Base directory for XML resource templates
    
    public function setManifestIdentifier(string $identifier = "default001") {
    }
}