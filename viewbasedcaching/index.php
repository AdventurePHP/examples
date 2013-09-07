<?php
// include the page controller
require('./APF/core/pagecontroller/pagecontroller.php');

// create the current page
import('core::frontcontroller', 'Frontcontroller');

/* @var $fC Frontcontroller */
$fC = &Singleton::getInstance('Frontcontroller');
$fC->setContext('examples::vbc');
echo $fC->start('examples::vbc::pres::templates', 'vbcmain');

// display benchmark report if desired
if (isset($_REQUEST['benchmarkreport']) && $_REQUEST['benchmarkreport'] == 'true') {
   echo Singleton::getInstance('BenchmarkTimer')->createReport();
}