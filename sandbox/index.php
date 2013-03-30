<?php
// initialize language if is is sent by the browser
$lang = 'en';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de') > 0) {
   $lang = 'de';
}

// include the page controller
define('APPS__PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/apps');
include_once('./apps/core/pagecontroller/pagecontroller.php');

// prepare logger for different database drivers
import('core::logging', 'Logger');
/* @var $l Logger */
$l = & Singleton::getInstance('Logger');
$stdWriter = clone $l->getLogWriter(
   Registry::retrieve('apf::core', 'InternalLogTarget')
);
$l->addLogWriter('mysqlx', clone $stdWriter);
$l->addLogWriter('mysqli', clone $stdWriter);
$l->addLogWriter('pdo', clone $stdWriter);
$l->addLogWriter('sqlite', clone $stdWriter);

// write all log entries to file to allow easy debugging
$l->setLogThreshold(Logger::$LOGGER_THRESHOLD_ALL);

// create the sandbox page
import('core::frontcontroller', 'Frontcontroller');
$fC = & Singleton::getInstance('Frontcontroller');
/* @var $fC Frontcontroller */
$fC->setContext('myapp');
$fC->setLanguage($lang);

$fC->registerAction('modules::usermanagement::biz', 'UmgtAutoLoginAction');

echo $fC->start('sandbox::pres::templates', 'main');

/* @var $t BenchmarkTimer */
$t = & Singleton::getInstance('BenchmarkTimer');
echo '<!--' . $t->getTotalTime() . '-->';
if (isset($_REQUEST['benchmark']) && $_REQUEST['benchmark'] == 'true') {
   echo $t->createReport();
}
