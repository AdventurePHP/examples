<?php

use APF\core\benchmark\BenchmarkTimer;
use APF\core\configuration\ConfigurationManager;
use APF\core\configuration\provider\ini\IniConfigurationProvider;
use APF\core\database\config\StatementConfigurationProvider;
use APF\core\frontcontroller\FrontController;
use APF\core\loader\RootClassLoader;
use APF\core\loader\StandardClassLoader;
use APF\core\logging\Logger;
use APF\core\registry\Registry;
use APF\core\singleton\Singleton;

// initialize language if is is sent by the browser
$lang = 'en';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de') > 0) {
   $lang = 'de';
}

// ID#241: initialize date/time environment
$timezone = ini_get('date.timezone');
if (empty($timezone)) {
   ini_set('date.timezone', 'UTC');
}

$context = 'myapp';

// pre-define the root path of the root class loader (if necessary)
$dir = dirname($_SERVER['SCRIPT_FILENAME']);
$apfClassLoaderRootPath = $dir . '/APF';
$apfClassLoaderConfigurationRootPath = $dir . '/config/APF';
include_once('./APF/core/bootstrap.php');

// define class loader for page resources
RootClassLoader::addLoader(new StandardClassLoader('SB', $dir . '/SB'));

// optional: define custom class loader to be able to separate the APF from your custom application's src folder
RootClassLoader::addLoader(new StandardClassLoader('APP', $dir . '/APP'));

// configure log writer used within the sandbox
/* @var $logger Logger */
$logger = Singleton::getInstance(Logger::class);
$writer = $logger->getLogWriter(Registry::retrieve('APF\core', 'InternalLogTarget'));
$logger->addLogWriter('login', clone $writer);
$logger->addLogWriter('registration', clone $writer);
$logger->addLogWriter('mysqli', clone $writer);

/* @var $iniProvider IniConfigurationProvider */
$iniProvider = ConfigurationManager::retrieveProvider('ini');
$iniProvider->setOmitConfigSubFolder(true);

// Configure statement configuration provider (required for pager etc.)
$sqlProvider = new StatementConfigurationProvider();
$sqlProvider->setOmitConfigSubFolder(true);
ConfigurationManager::registerProvider('sql', $sqlProvider);

// create the sandbox page
$fC = Singleton::getInstance(FrontController::class);
/* @var $fC FrontController */
$fC->setContext($context);
$fC->setLanguage($lang);

// Only register action in case the UMGT has been setup'd with the sandbox!
// To avoid exceptions, add some sophisticated checks
try {
   // first, try to load database configuration
   $config = ConfigurationManager::loadConfiguration(
         'APF\core\database',
         $context,
         $lang,
         Registry::retrieve('APF\core', 'Environment'),
         'connections.ini'
   );

   // secondly, try to get the right config section
   if (!$config->hasSection('Sandbox-UMGT')) {
      throw new Exception('Sandbox config not present!');
   }

   $fC->registerAction('APF\modules\usermanagement\biz', 'UmgtAutoLoginAction');
} catch (Exception $e) {
   // expected situation when UMGT has not been setup'd
}

echo $fC->start('SB\pres\templates', 'main');

/* @var $t APF\core\benchmark\BenchmarkTimer */
$t = Singleton::getInstance(BenchmarkTimer::class);
echo '<!--' . $t->getTotalTime() . '-->';
if (isset($_REQUEST['benchmark']) && $_REQUEST['benchmark'] == 'true') {
   echo $t->createReport();
}
