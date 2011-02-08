<?php
// initialize language if language was sent by the browser
$lang = 'en';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de') > 0) {
   $lang = 'de';
}

// configure PHP's error message type
ini_set('html_errors', 'off');

// include the pagecontroller
include_once('./apps/core/pagecontroller/pagecontroller.php');

// create the sandbox page
$page = new Page();
$page->setContext('myapp');
$page->setLanguage($lang);
$page->loadDesign('sandbox::pres::templates', 'main');
echo $page->transform();
?>