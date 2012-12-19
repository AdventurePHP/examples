<?php
class news_create_controller extends BaseDocumentController {
   public function transformContent() {
      $this->getForm('create-entry')->transformOnPlace();
   }
}