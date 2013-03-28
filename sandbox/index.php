<?php
// initialize language if is is sent by the browser
$lang = 'en';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de') > 0) {
   $lang = 'de';
}

// pre-define the root path of the root class loader (if necessary)
$apfClassLoaderRootPath = dirname($_SERVER['SCRIPT_FILENAME']) . '/APF';
include_once('./APF/core/bootstrap.php');

// optional: define custom class loader to be able to separate the APF from your custom application's src folder
use APF\core\loader\RootClassLoader;
use APF\core\loader\StandardClassLoader;

RootClassLoader::addLoader(new StandardClassLoader('SANDBOX', dirname($_SERVER['SCRIPT_FILENAME']) . '/SANDBOX'));

// create the sandbox page
use APF\core\singleton\Singleton;
use APF\core\frontcontroller\Frontcontroller;

$fC = & Singleton::getInstance('APF\core\frontcontroller\Frontcontroller');
/* @var $fC Frontcontroller */
$fC->setContext('myapp');
$fC->setLanguage($lang);

//$fC->registerAction('modules::usermanagement::biz', 'UmgtAutoLoginAction');

echo $fC->start('APF\sandbox\pres\templates', 'main');

use APF\core\benchmark\BenchmarkTimer;

/* @var $t APF\core\benchmark\BenchmarkTimer */
$t = & Singleton::getInstance('APF\core\benchmark\BenchmarkTimer');
if (isset($_REQUEST['benchmark']) && $_REQUEST['benchmark'] == 'true') {
   echo $t->createReport();
}
echo '<!--' . $t->getTotalTime() . '-->';