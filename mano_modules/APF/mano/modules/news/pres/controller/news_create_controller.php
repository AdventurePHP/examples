<?php
class news_create_controller extends base_controller {
   public function transformContent() {
      $this->__getForm('create-entry')->transformOnPlace();
   }
}
?>