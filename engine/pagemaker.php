<?php
include_once 'layouts.php';
include_once 'utility.php';
include_once 'phpfilewriter.php';

class PageMaker {

	private $srcDir;
	private $phpFileWriter;

	public function __construct($data) {
		$this->srcDir = $data['srcDir'];
		$this->phpFileWriter = new phpFileWriter();
	}

	public function makeSite(){
		$this->removeBuiltDirectory();
		
		$this->writeBuiltFileStructure();
	}

	private function removeBuiltDirectory(){
		if(is_dir('built')){
			Utility::deleteDirectory('built');
		}
	}

	private function writeBuiltFileStructure(){

		mkdir('built');

		$siteFiles = array();
		Utility::getDirContents('src/site', $siteFiles);

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
		$newFilepath = str_replace('src/site', 'built', $newFilepath);
		$newFilepath = getcwd() . $newFilepath;
		return $newFilepath;
	}

}