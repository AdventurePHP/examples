<?php
use APF\core\frontcontroller\Frontcontroller;
use APF\core\singleton\Singleton;

include_once('./APF/core/bootstrap.php');

/* @var $fC Frontcontroller */
$fC = &Singleton::getInstance('APF\core\frontcontroller\Frontcontroller');
echo $fC->start('APF\examples\calc\pres\templates', 'calc');