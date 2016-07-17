<?php

class Config{

	private $sourceDirectory = 'src';
	private $builtDirectory = 'built';
	private $siteDirectory = 'src/site';
	private $layoutsDirectory = 'src/layouts';
	private $configLocation = '';
	private $configContents = array();

	public function __construct($configLocation='_config.json'){
		$configContents = $this->readConfig($configLocation);
		$this->parseConfigContents($configContents);

		$this->configLocation = $configLocation;
	}

	public function getBuiltDirectory(){
		return $this->builtDirectory;
	}

	public function getSiteDirectory(){
		return $this->siteDirectory;
	}

	public function getLayoutsDirectory(){
		return $this->layoutsDirectory;
	}

	public function getSourceDirectory(){
		return $this->sourceDirectory;
	}

	public function getBaseUrl(){
		return $this->baseUrl;
	}

	public function getConfigContents(){
		return $this->configContents;
	}

	private function parseConfigContents($configContents) {
		$configContents['baseUrl'] = $this->parseBaseUrl($configContents['baseUrl']);
		$this->configContents = $configContents;
	}

	private function parseBaseUrl($baseUrl){
		if($baseUrl === 'FILE_SYSTEM') {
			return 'file://' . getcwd() . '/'. $this->getBuiltDirectory();
		}

		return $baseUrl;
	}

	private function readConfig($configLocation) {
		$configContents = json_decode(file_get_contents($configLocation), true);

		if($configContents === null){
			throw new Exception('Invalid Config at ' . $configLocation);
		}
		else{
			return $configContents;
		}
	}
}