<?php
include_once 'pagemaker.php';

$srcDir = 'src';
$pagemaker = new PageMaker(array(
	'srcDir' => $srcDir
));

$pagemaker->makeSite();