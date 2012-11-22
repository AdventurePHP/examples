<?php
import('mano::core::biz', 'DynamicModulesModel');

class MenuImportTag extends ImportTemplateTag {

   public function onParseTime() {
      $model = &Singleton::getInstance('DynamicModulesModel');
      /* @var $model DynamicModulesModel */
      $this->setAttribute('namespace', $model->getNamespace());
      $this->setAttribute('template', $model->getNaviView());
      parent::onParseTime();
   }

}