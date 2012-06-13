<?php
import('mano::core::biz', 'DynamicModulesModel');

class content_taglib_importdesign extends core_taglib_importdesign {

   public function onParseTime() {
      $model = &Singleton::getInstance('DynamicModulesModel');
      /* @var $model DynamicModulesModel */
      $this->setAttribute('namespace', $model->getNamespace());
      $this->setAttribute('template', $model->getContentView());
      parent::onParseTime();
   }

}