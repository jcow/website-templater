<?php
include_once 'layouts.php';
include_once 'utility.php';
include_once 'phpfilewriter.php';

class PageMaker {

	private $phpFileWriter;

	public function __construct($config) {
		$this->config = $config;
		$this->phpFileWriter = new phpFileWriter($config);
	}

	public function makeSite(){
		$this->removeBuiltDirectory();
		
		$this->writeBuiltFileStructure();
	}

	private function removeBuiltDirectory(){
		if(is_dir($this->config->getBuiltDirectory())){
			Utility::deleteDirectory($this->config->getBuiltDirectory());
		}
	}

	private function writeBuiltFileStructure(){

		mkdir($this->config->getBuiltDirectory());

		$siteFiles = array();
		Utility::getDirContents(
			$this->config->getSiteDirectory(), 
			$siteFiles
		);

		foreach($siteFiles as $siteFilepath) {

			$builtFilepath = $this->getBuiltFilepath($siteFilepath);

			if(is_dir($siteFilepath)) {
				mkdir($builtFilepath);
			}
			else{
				$this->writeBuiltFile($siteFilepath, $builtFilepath);
			}

		}
	}

	private function writeBuiltFile($siteFilepath, $builtFilepath){
		if (strrpos($siteFilepath, ".php") !== false) {
			$this->phpFileWriter->write($siteFilepath, $builtFilepath);
		}
		else{
			copy($siteFilepath, $builtFilepath);
		}
	}

	private function getBuiltFilepath($siteFile){
		$newFilepath = str_replace(getcwd(), '', $siteFile);	
		$newFilepath = str_replace(
			$this->config->getSiteDirectory(), 
			$this->config->getBuiltDirectory(), 
			$newFilepath
		);
		$newFilepath = getcwd() . $newFilepath;
		return $newFilepath;
	}

}