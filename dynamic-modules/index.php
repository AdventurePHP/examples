<?php
use APF\core\frontcontroller\Frontcontroller;
use APF\core\logging\Logger;
use APF\core\singleton\Singleton;

include('./APF/core/bootstrap.php');

/* @var $logger Logger */
$logger = Singleton::getInstance('APF\core\logging\Logger');
$writer = $logger->getLogWriter(\APF\core\registry\Registry::retrieve('APF\core', 'InternalLogTarget'));
$logger->addLogWriter('mysqli', clone $writer);

/* @var $fc Frontcontroller */
$fc = &Singleton::getInstance('APF\core\frontcontroller\Frontcontroller');
$fc->setContext('app-context');
$fc->registerAction('APF\examples\dynamicmodules\core\biz', 'modules-init');
echo $fc->start('APF\examples\dynamicmodules\site\pres\templates', 'main');