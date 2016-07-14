
<?php


class Utility{

	public function __construct(){}

	public static function getDirContents($dir, &$results = array()){
		$files = scandir($dir);

		foreach($files as $key => $value){
		    $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
		    if(!is_dir($path)) {
		        $results[] = $path;
		    } 
		    else if($value != "." && $value != "..") {
		        $results[] = $path;
		        self::getDirContents($path, $results);
		    }

		}

		return $results;
	}

	public static function deleteDirectory($dir) {
	    if (!file_exists($dir)) {
	        return true;
	    }

	    if (!is_dir($dir)) {
	        return unlink($dir);
	    }

	    foreach (scandir($dir) as $item) {
	        if ($item == '.' || $item == '..') {
	            continue;
	        }

	        if (!self::deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
	            return false;
	        }

	    }

	    return rmdir($dir);
	}
}