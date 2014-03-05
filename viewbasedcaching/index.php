<?php
use APF\core\frontcontroller\Frontcontroller;
use APF\core\singleton\Singleton;

require('./APF/core/bootstrap.php');

/* @var $fC Frontcontroller */
$fC = & Singleton::getInstance('APF\core\frontcontroller\Frontcontroller');
$fC->setContext('examples\vbc');
echo $fC->start('APF\examples\vbc\pres\templates', 'vbcmain');

// display benchmark report if desired
if (isset($_REQUEST['benchmarkreport']) && $_REQUEST['benchmarkreport'] == 'true') {
   echo Singleton::getInstance('APF\core\benchmark\BenchmarkTimer')->createReport();
}