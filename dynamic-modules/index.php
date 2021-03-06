<?php
use APF\core\configuration\ConfigurationManager;
use APF\core\configuration\provider\ini\IniConfigurationProvider;
use APF\core\frontcontroller\FrontController;
use APF\core\loader\RootClassLoader;
use APF\core\loader\StandardClassLoader;
use APF\core\logging\Logger;
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

/* @var $logger Logger */
$logger = Singleton::getInstance(Logger::class);
$writer = $logger->getLogWriter(\APF\core\registry\Registry::retrieve('APF\core', 'InternalLogTarget'));
$logger->addLogWriter('mysqli', clone $writer);

/* @var $fc FrontController */
$fc = Singleton::getInstance(FrontController::class);
$fc->setContext('app-context');
$fc->registerAction('EXAMPLE\dynamicmodules\core\biz', 'modules-init');
echo $fc->start('EXAMPLE\dynamicmodules\site\pres\templates', 'main');
