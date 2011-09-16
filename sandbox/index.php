<?php
// initialize language if is is sent by the browser
$lang = 'en';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de') > 0) {
   $lang = 'de';
}

// configure PHP's error message type
ini_set('html_errors', 'off');

// include the pagecontroller
include_once('./apps/core/pagecontroller/pagecontroller.php');

// create the sandbox page
import('core::frontcontroller', 'Frontcontroller');
$fC = &Singleton::getInstance('Frontcontroller');
/* @var $fC Frontcontroller */
$fC->setContext('myapp');
$fC->setLanguage($lang);
echo $fC->start('sandbox::pres::templates', 'main');
?>