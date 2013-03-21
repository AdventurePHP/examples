<?php
namespace SANDBOX\sandbox\pres\controller;

use APF\core\pagecontroller\BaseDocumentController;

class DifferentClassLoaderTestController extends BaseDocumentController {

   public function transformContent() {
      $this->setPlaceHolder('controller-dir', dirname(__FILE__));
   }

}