<?php

include_once 'pagemetadata.php';

class PHPFileWriter{

	public function __construct($config){
		$this->config = $config;
	}

	public function write($siteFilepath, $builtFilepath){

		$builtFilepath = str_replace(".php", ".html", $builtFilepath);

		$pageContent = $this->readPHPFile($siteFilepath, array());

		$pagemetadata = new PageMetaData();
		$pageContent = $pagemetadata->extractAndReplace($pageContent);

		$layout = $pagemetadata->getItem('layout');
		if($layout === null) {
			$layout = 'default';
		}

		$pageConfig = array('config' => $this->config->getConfigContents());
		$pageConfig = array_merge($pageConfig, $pagemetadata->getMetaData());
		$pageConfig = array_merge($pageConfig, array(
			'pageContent' => $pageContent
		));

		$newPageContent = $this->readPHPFile($this->config->getLayoutsDirectory() . '/' . $layout . '.php', $pageConfig);

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