<?php
namespace APF\examples\dynamicmodules\core\pres\taglib;

use APF\core\benchmark\BenchmarkTimer;
use APF\core\pagecontroller\ImportTemplateTag;
use APF\core\singleton\Singleton;
use APF\examples\dynamicmodules\core\biz\DynamicModulesModel;

class MenuImportTag extends ImportTemplateTag {

   /**
    * @var bool Indicates whether content exists for the navigation area or not.
    */
   private $isEmpty = false;

   public function onParseTime() {
      /* @var $model DynamicModulesModel */
      $model = & Singleton::getInstance('APF\examples\dynamicmodules\core\biz\DynamicModulesModel');

      $namespace = $model->getNamespace();
      $view = $model->getNaviView();

      if (empty($namespace) || empty($view)) {
         $this->isEmpty = true;
         return;
      }

      $this->setAttribute('namespace', $namespace);
      $this->setAttribute('template', $view);
      parent::onParseTime();
   }

   public function transform() {
      return $this->isEmpty === false ? parent::transform() : '';
   }

}