<?php
include_once 'pagemaker.php';
include_once 'config.php';

$config = new Config();
$pagemaker = new PageMaker($config);

$pagemaker->makeSite();