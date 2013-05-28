<?php
require_once __DIR__ . '/../src/Annotations/annotations.php';
require_once __DIR__ . '/../src/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespace('Phpjaxrs', __DIR__.'/../src');
//$loader->registerNamespace('Phpjaxrs\Bean', __DIR__.'/../src/Phpjaxrs/Bean');
