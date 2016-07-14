<?php

include_once 'pagemetadata.php';

class PHPFileWriter{

	private $layouts = array();

	public function __construct(){
		
	}

	public function write($siteFilepath, $builtFilepath){

		$builtFilepath = str_replace(".php", ".html", $builtFilepath);

		$pageContent = $this->readPHPFile($siteFilepath, array(
			'foobar' => 'This is the stuff to pass to each php file'
		));

		$pagemetadata = new PageMetaData();
		$pageContent = $pagemetadata->extractAndReplace($pageContent);

		$layout = $pagemetadata->getItem('layout');
		if($layout === null) {
			$layout = 'default';
		}

		$newPageContent = $this->readPHPFile('src/layouts/' . $layout . '.php', array(
			'pageContent' => $pageContent
		));

		$this->writePHPFile($builtFilepath, $newPageContent);
	}

	private function writePHPFile($builtFilepath, $pageContent){
		$myfile = fopen($builtFilepath, "w") or die("Unable to open file! " . $builtFilepath);
		fwrite($myfile, $pageContent);
		fclose($myfile);
	}

	private function readPHPFile($template, $_pageVars){

		ob_start();
		include($template);
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}