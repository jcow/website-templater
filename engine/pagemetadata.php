<?php


class PageMetaData{

	private $metadata = array();

	// replace anything between 3 --- 
	// /s spans the regex across multiple lines
	private $pattern = "/---(.*)---/s";

	public function getMetaData(){
		return $this->metadata;
	}

	public function getItem($index){
		if(array_key_exists($index, $this->metadata)) {
			return $this->metadata[$index];
		}

		return null;
	}

	public function extractAndReplace($pageContent) {
		$outputArray = array();

		if(preg_match($this->pattern, $pageContent, $outputArray) !== false) {
			$this->parseMetaData($outputArray[1]);
			return preg_replace($this->pattern, '', $pageContent, 1);
		}
		else {
			return false;
		}
	}

	private function parseMetaData($metaDataString) {
		$parts = explode(PHP_EOL, $metaDataString);
		foreach($parts as $part) {
			if(strpos($part, ':') !== false){
				$newParts = explode(':', $part);
				$this->metadata[$newParts[0]] = trim($newParts[1]);
			}
		}
	}
}