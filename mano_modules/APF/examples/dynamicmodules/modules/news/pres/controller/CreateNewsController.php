<?php
namespace APF\examples\dynamicmodules\modules\news\pres\controller;

use APF\core\pagecontroller\BaseDocumentController;

class CreateNewsController extends BaseDocumentController {
   public function transformContent() {
      $this->getForm('create-entry')->transformOnPlace();
   }
}