<?php
   // Redirect to language pages, if language was sent by the browser
   if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){

      // Show german pages
      if(substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'],'de') > 0){
         header('Location: ./de');
         exit(0);
       // end if
      }

      // Show english pages
      if(substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'],'en') > 0){
         header('Location: ./en');
         exit(0);
       // end if
      }

    // end if
   }

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
   $Page->loadDesign('sites::apfexample','pres/templates/website');

   // Transform and print output
   echo $Page->transform();
?>