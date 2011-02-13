<?php
import('mano::core::biz', 'DynamicModulesModel');
import('tools::request', 'RequestHandler');

class ModulesBootstrapAction extends AbstractFrontcontrollerAction {

   public function run() {
      
      $moduleName = RequestHandler::getValue('mod');

      $conn = &$this->__getServiceObject('core::database', 'ConnectionManager')->getConnection('MySQL');
      /* @var $conn MySQLiHandler */

      $select = 'SELECT * FROM modules WHERE `key` = \''.$conn->escapeValue($moduleName).'\'';
      $result = $conn->executeTextStatement($select);
      $data = $conn->fetchData($result);
      
      if($data !== false){

         $model = &Singleton::getInstance('DynamicModulesModel');
         /* @var $model DynamicModulesModel */

         // prepare model
         $model->setNamespace($data['namespace'].'::pres::templates');
         $model->setNaviView($data['menu_template']);
         $model->setContentView($data['content_template']);

         // execute the fc action for the desired module
         $action = &$this->__getServiceObject($data['namespace'].'::biz', $data['fc_action']);
         /* @var $action AbstractFrontcontrollerAction */
         $action->setParentObject($this->getParentObject());
         $action->setActionNamespace($data['namespace']);
         $action->setActionName($data['fc_action']);
         $action->setContext($this->getContext());
         $action->setLanguage($this->getLanguage());
         $action->run();

      }

   }

}
?>