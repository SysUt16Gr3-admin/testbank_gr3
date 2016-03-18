<?php

class ManifestParser{

	//holder objektet
	protected $xml_obj = null;

	//holder output-arrayet
	protected $output = array();

	//XML-filen karakter
	protected $char_set = 'UTF-8';

	function ManifestParser(){ }

	//parse filen
	function parse($minFil){

		$this->output = array();
		
		//lage en ny XML-parser
		$this->xml_obj = xml_parser_create($this->char_set);
		
		//bruke XML Parser innenfor et objekt
		xml_set_object($this->xml_obj,$this);
		
		//Sette opp karakter data handler for XML parser
		xml_set_character_data_handler($this->xml_obj, 'handler');
		
		//Sette opp start- og sluttelement. Ta med referanse til XML Parser
		xml_set_element_handler($this->xml_obj, "tagStart", "tagEnd");
		
		$fp = fopen($minFil, "r");

		if (!$fp) {
			die("Feil ved å åpne filen: $minFil");
			return false;
		}

		while ($filInnhold = fread($fp, 4096)) {
			if (!xml_parse($this->xml_obj, $filInnhold, feof($fp))) {
				die(sprintf("XML feil: %s på linje %d",
						xml_error_string(xml_get_error_code($this->xml_obj)),
						xml_get_current_line_number($this->xml_obj)));
				xml_parser_free($this->xml_obj);
			}
		}

		return $this->output;
	}
	
	//Metode handler en tag-start treffen av XML parser 
	function tagStart($parser, $name, $attribs){
		$_content = array('name' => $name);
		if(!empty($attribs))
			$_content['attrs'] = $attribs;
			array_push($this->output, $_content);
	}

	function handler($parser, $data){
		if(!empty($data)) {
			$_output_idx = count($this->output) - 1;
			if(!isset($this->output[$_output_idx]['content']))
				$this->output[$_output_idx]['content'] = $data;
				else
					$this->output[$_output_idx]['content'] .= $data;
		}
	}

	//Metode handler en tag-slutt treffen av XML parser 
	function tagEnd($parser, $name){
		if(count($this->output) > 1) {
			$_data = array_pop($this->output);
			$_output_idx = count($this->output) - 1;
			$this->output[$_output_idx]['child'][] = $_data;
		}
	}

}