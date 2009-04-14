<?php
   // PHP_EOL fix
   if(!defined('PHP_EOL')){
      define('PHP_EOL',"\n");
   }

   // Configure PHP's error message type
   ini_set('html_errors','off');

   // include the pagecontroller
   include_once('d:/Apache2/htdocs/apps/core/pagecontroller/pagecontroller.php5');

   // Create new Page object
   $Page = new Page();

   // Load design to create DOM
   $Page->loadDesign('sites::apfexample','pres/templates/de/pagewithmenu');

   // Transform and print output
   echo $Page->transform();

   // Display benchmark report weather benchmarkreport=true is present in the URL
   if(isset($_REQUEST['benchmarkreport'])){
      if($_REQUEST['benchmarkreport'] == 'true'){
         $T = &Singleton::getInstance('benchmarkTimer');
         echo $T->createReport();
       // end if
      }
    // end if
   }
?>