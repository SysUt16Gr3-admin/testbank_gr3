<?php

class ManifestParser{

	
	protected $xml_obj = null;
	protected $output = array();
	protected $char_set = 'UTF-8';
	
	function ManifestParser(){ }
	
	function parse($minFil){

		$this->output = array();
				
		$this->xml_obj = xml_parser_create($this->char_set);
				
		xml_set_object($this->xml_obj,$this);
				
		xml_set_character_data_handler($this->xml_obj, 'handler');
				
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

	function tagEnd($parser, $name){
		if(count($this->output) > 1) {
			$_data = array_pop($this->output);
			$_output_idx = count($this->output) - 1;
			$this->output[$_output_idx]['child'][] = $_data;
		}
	}
}