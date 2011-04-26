<?php
include_once('./apps/core/pagecontroller/pagecontroller.php');
import('core::frontcontroller', 'Frontcontroller');
$fC = &Singleton::getInstance('Frontcontroller');
echo $fC->start('custom-modules::calc::pres::templates', 'calc');
?>