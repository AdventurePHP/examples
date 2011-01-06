<?php
include_once('./apps/core/pagecontroller/pagecontroller.php');
$page = new Page();
$page->loadDesign('custom-modules::calc::pres::templates', 'calc');
echo $page->transform();
?>