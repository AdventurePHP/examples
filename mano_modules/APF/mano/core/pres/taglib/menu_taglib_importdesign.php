<?php
import('mano::core::biz', 'DynamicModulesModel');

class menu_taglib_importdesign extends core_taglib_importdesign {

   public function onParseTime() {
      $model = &Singleton::getInstance('DynamicModulesModel');
      /* @var $model DynamicModulesModel */
      $this->setAttribute('namespace', $model->getNamespace());
      $this->setAttribute('template', $model->getNaviView());
      parent::onParseTime();
   }

}