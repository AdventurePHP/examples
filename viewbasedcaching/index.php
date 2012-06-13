<?php
// include the page controller
require('./apps/core/pagecontroller/pagecontroller.php');

// create the current page
import('core::frontcontroller', 'Frontcontroller');

/* @var $fC Frontcontroller */
$fC = &Singleton::getInstance('Frontcontroller');
$fC->setContext('sites::vbc');
echo $fC->start('sites::vbc::pres::templates', 'vbcmain');

// display benchmark report if desired
if (isset($_REQUEST['benchmarkreport']) && $_REQUEST['benchmarkreport'] == 'true') {
   echo Singleton::getInstance('BenchmarkTimer')->createReport();
}