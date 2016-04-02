<?php

require_once 'LMSResource.php';
require_once 'Manifest.php';
require_once 'IMS_QTI_ManifestResource.php';

/*
 * Class that supports generating the manifest xml file based on a set of resource xml files.
 */
class IMS_QTI_Manifest extends Manifest{
    private $IMS_QTI_RESORCE_TEMPLATE = "ims_qti_manifest_resource.xml";
    private $IMS_QTI_RESOURCE = "imsqti_item_xmlv2p1";
   	private $xml;
	private $xmlVersion = "1.0";
	private $xmlEncoding = "UTF-8";
    private $testDirectoryPath;
	private $manifestElement;
    private $resourcesElement;
    private $manifestIdentifier;  // Mandatory element, must be unique whitin the manifest
    private $resourceTypes = array("choiceInteraction", "gapMatchInteraction", "textEntryInteraction",
                                    "matchInteraction", "orderInteraction");

    /**
     * IMS_QTI_Manifest constructor.
     * @param string $testDirectory the directory that contains the resource files to be included in the manifest
     * @param string $manifestIdentifier mandatory attribute of the manifest element, must be unique within the manifest
     */
    public function __construct(string $testDirectory, string $manifestIdentifier = "default001") {
        $this->testDirectoryPath = $this->baseTestDirectory . "/" . $testDirectory;
        $this->manifestIdentifier = $manifestIdentifier;
		$this->xml = new DOMDocument("$this->xmlVersion", "$this->xmlEncoding");
        $this->xml->formatOutput = true;
		echo "IMS_QTI_Manifest object created" . "<br>\n";
	}

    /**
     * Creates the manifest base structure, excluding <resource> elements
     */
    public function createManifestBaseElements() {
		echo "Creating the base structure of the manifest" . "<br>\n";
		$this->manifestElement = $this->xml->createElement("manifest");
        $this->manifestElement->setAttribute("identifier", $this->manifestIdentifier);
		$this->xml->appendChild($this->manifestElement);
        $metadata = $this->manifestElement->appendChild($this->xml->createElement("metadata"));
        $organizations = $this->manifestElement->appendChild($this->xml->createElement("organizations"));
        $this->resourcesElement = $this->manifestElement->appendChild($this->xml->createElement("resources"));
	}

    /**
     * Outputs the content of the manifest
     */
    public function displayManifest() {
		echo "Content of manifest:" . "<br>\n";
        $xmlContent = $this->xml->saveXML();
        echo "<br>", "<pre>", htmlentities($xmlContent), "</pre>";
	}

    /**
     * Saves the content of the manifest to a file in the same directory as the resource files are located
     *
     * @param string $filename name of file the manifest shall be saved to. Should not be changed from default value.
     */
    public function saveManifestToFile(string $filename = "imsmanifest.xml") {
        if ($this->xml->save($this->testDirectoryPath . "/" . $filename))
            echo "Manifest saved to file $filename in directory $this->testDirectoryPath";
        else
            echo "Failed to save manifest to $filename in directory $this->testDirectoryPath";
    }

    /**
     * Extracts data from resource .xml file and returns a ManifestResource instance containing it's relevant data
     * 
     * @param string $resourceFile
     * @return ManifestResource $resourceDataInstance
     */
    private function createResourceDataInstance(string $resourceFile) : ManifestResource {
        $xmlResource = new DOMDocument();
        $xmlResource->load($this->testDirectoryPath . "/" . $resourceFile);

        echo "<br><br>\n\n";
        echo "Creates the resource data instance for the file $resourceFile with the following values:<br>\n";
        $assessmentItemAttributes = $xmlResource->getElementsByTagName("assessmentItem")->item(0)->attributes;
        echo "Identifier: " .  $identifier = $assessmentItemAttributes->getNamedItem("identifier")->nodeValue, "<br>\n";
        echo "Title: " . $title = $assessmentItemAttributes->getNamedItem("title")->nodeValue, "<br>\n";

        // Iterates through the available resource types to find the resource type of this resource file
        foreach ($this->resourceTypes as $type) {
            if (!is_null($type_element = $xmlResource->getElementsByTagName($type)->item(0))) {
                echo "Question type: " . $questionType = $type_element->nodeName, "<br>\n";
                $resourceDataInstance = new IMS_QTI_ManifestResource($resourceFile, 
                                                                    $resourceFile, 
                                                                    $questionType,  
                                                                    $title,
                                                                    $resourceFile);
                echo "Dump (print_r) of the resource data instance created: <br>\n";
                print_r($resourceDataInstance); // debug
                echo "<br><br>\n\n";
                break; // Exit loop if match is found
            }
        }
        return $resourceDataInstance;
	}

    /**
     * Builds and returns an IMS QTI manifest resource element based on the corresponding resource file
     *
     * @param string $resourceTemplatesDirectory
     * @param ManifestResource $resourceDataInstance
     * @return DOMNode
     */
    public function buildManifestResourceElement(string $resourceTemplatesDirectory,
                                                 ManifestResource $resourceDataInstance) : DOMNode {
        $xml = new DOMDocument();
        echo "Building manifest IMS_QTI resource element\n";
        $resourceTemplateFile = "./" . $resourceTemplatesDirectory . "/" . $this->IMS_QTI_RESORCE_TEMPLATE;
        if ($loaded = $xml->load($resourceTemplateFile)) {
            $resourceElement = $xml->getElementsByTagName("resource")->item(0);
            $resourceElement->setAttribute("identifier", $resourceDataInstance->getIdentifier());
            $resourceElement->setAttribute("href", $resourceDataInstance->getHref());
            $resourceElement->setAttribute("type", $resourceDataInstance->getFormat());
            $langstringElement = $xml->getElementsByTagName("langstring")->item(0);
            $langstringElement->nodeValue = $resourceDataInstance->getLangstring();
            $interactionTypeElement = $xml->getElementsByTagName("interactionType")->item(0);
            $interactionTypeElement->nodeValue = $resourceDataInstance->getType();
            $fileElement = $xml->getElementsByTagName("file")->item(0);
            $fileElement->setAttribute("href", $resourceDataInstance->getFileHref());
        }
        else {
            echo "Could not load resource template file: " . $resourceTemplateFile;
            $resourceElement = null;
        }
        return $resourceElement;
    }

	/**
	 * Iterates through a directory containing resource files and adds the resource to the manifest
     *
	 * @param string $directory directory containing the resource files
     * @param string $matcherExp resource filename must start with this string
     */
	public function addResourceToManifest(string $matcherExp) {
        $entries = scandir($this->testDirectoryPath);
        $fileList = array();

		// Create array of resource files to be included in the manifest
        foreach ($entries as $entry) {
            if (strpos($entry, $matcherExp) === 0) {  // true if $entry starts with $matcherExp
                $fileList[] = $entry;
            }
        }

        // For each resource file, extract required data from file, build the manifest <resource> element
        // and add to manifest
        foreach ($fileList as $file) {
            $resourceDataInstance = $this->createResourceDataInstance($file);
            $manifestResourceElement = $this->buildManifestResourceElement($this->resourceTemplatesDirectory, $resourceDataInstance);
            $node = $this->xml->importNode($manifestResourceElement, true);
            $this->resourcesElement->appendChild($node);
        }
	}
}