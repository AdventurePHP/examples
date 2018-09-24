<?php
namespace EXAMPLE\dynamicmodules\core\pres\taglib;

use EXAMPLE\dynamicmodules\core\biz\DynamicModulesModel;
use APF\core\singleton\Singleton;
use APF\core\pagecontroller\ImportTemplateTag;

class ContentImportTag extends ImportTemplateTag {

   public function onParseTime() {
      $model = Singleton::getInstance(DynamicModulesModel::class);
      /* @var $model DynamicModulesModel */
      $this->setAttribute('namespace', $model->getNamespace());
      $this->setAttribute('template', $model->getContentView());
      parent::onParseTime();
   }

}