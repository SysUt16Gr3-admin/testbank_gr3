<?php

require_once 'LMSResource.php';
require_once 'ManifestResource.php';

/*
 * Class that supports generating the manifest xml file based on a set of resources.
 */
class Manifest {
    private $directory;
	private $xml;
	private $xmlVersion = "1.0";
	private $xmlEncoding = "UTF-8";
	private $manifestElement;
    private $manifestResource;
    private $resourceTypes = array("choiceInteraction", "gapMatchInteraction", "textEntryInteraction",
                                    "matchInteraction", "orderInteraction");
	
	public function __construct(string $resource_directory = ".") {
        $this->directory = $resource_directory;
		$this->xml = new DOMDocument("$this->xmlVersion", "$this->xmlEncoding");
		echo "Manifest object created" . "<br>";
	}
	
	//Creates the xml root element, <manifest>
	public function setManifestElement() {
		echo "Creating the manifest element" . "<br>";
		$this->manifestElement = $this->xml->createElement("manifest");
		$this->xml->appendChild($this->manifestElement);
	}
	
	//Displays content of manifest
	public function displayManifest() {
		echo "Content of manifest:" . "<br>";
		echo $htmlString = $this->xml->saveXML() . "<br>";
	}


    /**
     * Extracts data from resource xml file and generates a ManifestResource instance containing the data
     * 
     * @param string $resourceFile
     * @return ManifestResource
     */
    private function createResourceDataInstance(string $resourceFile) : ManifestResource {
        $xmlResource = new DOMDocument();
        $xmlResource->load($this->directory . "/" . $resourceFile);

        echo "<br><br>";
        $assessmentItemAttributes = $xmlResource->getElementsByTagName("assessmentItem")->item(0)->attributes;
        echo $identifier = $assessmentItemAttributes->getNamedItem("identifier")->nodeValue;
        echo $title = $assessmentItemAttributes->getNamedItem("title")->nodeValue;

        // Iterates through the available resource types to find the resource type of this resource file
        foreach ($this->resourceTypes as $type) {
            if (!is_null($type_element = $xmlResource->getElementsByTagName($type)->item(0))) {
                echo $questionType = $type_element->nodeName;
                $resourceDataInstance = new ManifestResource($resourceFile, 
                                                                    $resourceFile, 
                                                                    $questionType,  
                                                                    $title,
                                                                    $resourceFile);
                print_r($resourceDataInstance); // debug
                break; // Exit loop if match is found
            }

        }
        //echo $type = $assessmentItemAttributes->getNamedItem("type")->nodeValue;


/*            <resource identifier="resource-item-92563" href="item92563.xml" type="imsqti_item_xmlv2p1">
                <metadata>
                    <imsmd:lom>
                        <imsmd:general>
                            <imsmd:title>
                                <imsmd:langstring xml:lang="en">FillInTheBlankText</imsmd:langstring>
                            </imsmd:title>
                        </imsmd:general>
                        <imsmd:technical>
                            <imsmd:format>text/x-imsqti-item-xml</imsmd:format>
                        </imsmd:technical>
                    </imsmd:lom>
                    <imsqti:qtiMetadata>
                        <imsqti:interactionType>textEntryInteraction</imsqti:interactionType>
                    </imsqti:qtiMetadata>
                </metadata>
                <file href="item92563.xml"/>
            </resource>
         */
        return $resourceDataInstance;
	}

    /**
     * Builds the manifest resource element that will be added to the manifest
     * 
     * @param $manifestResource ManifestResource
     * @return DOMElement
     */
    private function buildManifestResourceElement(ManifestResource $manifestResource) {
        $resourceElement = (new DOMDocument())->createElement("resource");
        $resourceElement->setAttribute("identifier", $manifestResource->getIdentifier());
        print_r ($resourceElement);
    }

	/**
	 * Iterates through a directory containing resource files and adds the resource to the manifest
     *
	 * @param $directory string directory containing the resource files
     * @param $matcherExp string resource filename must start with this string
     */
	public function addResourceToManifest(string $matcherExp) {
        $entries = scandir($this->directory);
        $fileList = array();

		// Create array of resource files to be included in the manifest
        foreach ($entries as $entry) {
            if (strpos($entry, $matcherExp) === 0) {  // true if $entry starts with $matcherExp
                $fileList[] = $entry;
            }
        }
        print_r($fileList); //debug

        // For each resource file, extract required data from file, build the manifest <resource> element
        // and add to manifest
        foreach ($fileList as $file) {
            $resourceDataInstance = $this->createResourceDataInstance($file);
            $manifestResourceElement = $this->buildManifestResourceElement($resourceDataInstance);
        }
	}
}