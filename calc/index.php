<?php
include_once('./APF/core/pagecontroller/pagecontroller.php');
import('core::frontcontroller', 'Frontcontroller');

/* @var $fC Frontcontroller */
$fC = &Singleton::getInstance('Frontcontroller');
echo $fC->start('examples::calc::pres::templates', 'calc');