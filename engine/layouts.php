<?php


class Layouts {

	const LAYOUT_DIR = 'layouts';

	private $sourceDir = null;
	private $layoutContents = [];

	public function __construct($sourceDir) { 
		$this->sourceDir = $sourceDir;
	}

	public function readLayouts() {
		$dir = $this->sourceDir . '/' . self::LAYOUT_DIR;
		$temp = scandir(realpath($dir));

		foreach($temp as $file) {
			if (strpos($file, '.php') !== false) {
				$index = str_replace('.php', '', $file);
				$this->layoutContents[$index] = file_get_contents($dir . '/' . $file);
			}
		}
	}

	public function getLayoutContent($whichLayout) {
		return $this->layoutContents[$whichLayout];
	}

}