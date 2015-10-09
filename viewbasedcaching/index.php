<?php
use APF\core\benchmark\BenchmarkTimer;
use APF\core\configuration\ConfigurationManager;
use APF\core\configuration\provider\ini\IniConfigurationProvider;
use APF\core\frontcontroller\Frontcontroller;
use APF\core\loader\RootClassLoader;
use APF\core\loader\StandardClassLoader;
use APF\core\singleton\Singleton;

// pre-define the root path of the root class loader (if necessary)
$dir = dirname($_SERVER['SCRIPT_FILENAME']);
$apfClassLoaderRootPath = $dir . '/APF';
$apfClassLoaderConfigurationRootPath = $dir . '/config/APF';
require('./APF/core/bootstrap.php');

// Define class loader for documentation page resources
RootClassLoader::addLoader(new StandardClassLoader('EXAMPLE', $dir . '/EXAMPLE', $dir . '/config/EXAMPLE'));

/* @var $iniProvider IniConfigurationProvider */
$iniProvider = ConfigurationManager::retrieveProvider('ini');
$iniProvider->setOmitConfigSubFolder(true);
$iniProvider->setOmitContext(true);

/* @var $fC Frontcontroller */
$fC = &Singleton::getInstance(Frontcontroller::class);
echo $fC->start('EXAMPLE\vbc\pres\templates', 'main');

// display benchmark report if desired
if (isset($_REQUEST['benchmarkreport']) && $_REQUEST['benchmarkreport'] == 'true') {
   echo Singleton::getInstance(BenchmarkTimer::class)->createReport();
}
