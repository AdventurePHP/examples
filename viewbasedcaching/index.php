<?php
// include the page controller
require('./apps/core/pagecontroller/pagecontroller.php');

// create the current page
$page = new Page();
$page->setContext('sites::vbc');
$page->loadDesign('sites::vbc::pres::templates', 'vbcmain');
echo $page->transform();

// display benchmark report if desired
if (isset($_REQUEST['benchmarkreport']) && $_REQUEST['benchmarkreport'] == 'true') {
   echo Singleton::getInstance('benchmarkTimer')->createReport();
}
?>