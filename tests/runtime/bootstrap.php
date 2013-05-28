<?php
//require_once __DIR__ . '/../../src/Annotations/annotations.php';
require_once __DIR__ . '/../../src/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespace('zpt', __DIR__.'/../../src');
$loader->registerNamespace('Phpjaxrs', __DIR__.'/../../src');
$loader->registerNamespace('Fixtures', __DIR__.'/../fixtures');

//$annotationCollectionLoader = \Phpjaxrs\Annotation\CollectionLoader::getInstance();

//$loader->registerNamespace('Phpjaxrs\Bean', __DIR__.'/../src/Phpjaxrs/Bean');
