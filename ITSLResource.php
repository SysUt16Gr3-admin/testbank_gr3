<?php

include "LMSResource.php";

/** Base class for the different resource-types the LMS ITSL supports */
class ITSLResource extends LMSResource {
	protected $xml;

	public function __construct() {
		$this->xml = new DOMDocument("1.0", "UTF-8");
		echo '<br/> Created ITSL Resource Object';
	}
}

?>