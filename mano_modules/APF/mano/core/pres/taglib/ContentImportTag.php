<?php
import('mano::core::biz', 'DynamicModulesModel');

class ContentImportTag extends ImportTemplateTag {

   public function onParseTime() {
      $model = &Singleton::getInstance('DynamicModulesModel');
      /* @var $model DynamicModulesModel */
      $this->setAttribute('namespace', $model->getNamespace());
      $this->setAttribute('template', $model->getContentView());
      parent::onParseTime();
   }

}