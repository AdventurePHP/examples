<?php
include('./APF/core/pagecontroller/pagecontroller.php');
import('core::frontcontroller', 'Frontcontroller');

$fc = &Singleton::getInstance('Frontcontroller');
/* @var $fc Frontcontroller */
$fc->setContext('app-context');
$fc->registerAction('mano::core::biz', 'modules-init');
echo $fc->start('mano::site::pres::templates', 'main');