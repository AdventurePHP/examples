<?php
use APF\core\frontcontroller\FrontController;
use APF\core\singleton\Singleton;
use APF\core\loader\RootClassLoader;
use APF\core\loader\StandardClassLoader;

// pre-define the root path of the root class loader (if necessary)
$dir = dirname($_SERVER['SCRIPT_FILENAME']);
$apfClassLoaderRootPath = $dir . '/APF';
require('./APF/core/bootstrap.php');

// Define class loader for documentation page resources
RootClassLoader::addLoader(new StandardClassLoader('EXAMPLE', $dir . '/EXAMPLE'));

/* @var $fC FrontController */
$fC = Singleton::getInstance(FrontController::class);
echo $fC->start('EXAMPLE\calc\pres\templates', 'calc');
