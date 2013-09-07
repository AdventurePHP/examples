<?php
namespace APF\examples\dynamicmodules\core\pres\taglib;

use APF\examples\dynamicmodules\core\biz\DynamicModulesModel;
use APF\core\singleton\Singleton;
use APF\core\pagecontroller\ImportTemplateTag;

class MenuImportTag extends ImportTemplateTag {

   public function onParseTime() {
      $model = &Singleton::getInstance('APF\examples\dynamicmodules\core\biz\DynamicModulesModel');
      /* @var $model DynamicModulesModel */
      $this->setAttribute('namespace', $model->getNamespace());
      $this->setAttribute('template', $model->getNaviView());
      parent::onParseTime();
   }

}