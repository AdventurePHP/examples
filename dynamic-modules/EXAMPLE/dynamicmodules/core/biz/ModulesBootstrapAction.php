<?php
namespace EXAMPLE\dynamicmodules\core\biz;

use APF\core\database\DatabaseHandlerException;
use APF\core\database\MySQLiHandler;
use APF\core\frontcontroller\AbstractFrontcontrollerAction;
use APF\core\singleton\Singleton;
use APF\tools\link\LinkGenerator;
use APF\tools\link\Url;

class ModulesBootstrapAction extends AbstractFrontcontrollerAction {

   public function run() {

      /* @var $model DynamicModulesModel */
      $model = &Singleton::getInstance('EXAMPLE\dynamicmodules\core\biz\DynamicModulesModel');

      $conn = null;
      try {

         $moduleName = $this->getRequest()->getParameter('mod');

         /* @var $conn MySQLiHandler */
         $conn = &$this->getServiceObject('APF\core\database\ConnectionManager')->getConnection('modules');

         $select = 'SELECT * FROM modules WHERE `key` = \'' . $conn->escapeValue($moduleName) . '\'';
         $result = $conn->executeTextStatement($select);
         $data = $conn->fetchData($result);
         if ($data !== false) {

            // prepare model
            $model->setNamespace($data['namespace'] . '\pres\templates');
            $model->setNaviView($data['menu_template']);
            $model->setContentView($data['content_template']);

            // execute the fc action for the desired module
            $action = &$this->getServiceObject($data['namespace'] . '\biz\\' . $data['fc_action']);
            /* @var $action AbstractFrontcontrollerAction */
            $action->setActionNamespace($data['namespace']);
            $action->setActionName($data['fc_action']);
            $action->setContext($this->getContext());
            $action->setLanguage($this->getLanguage());
            $action->run();

         }

      } catch (DatabaseHandlerException $e) {

         if (strpos($e->getMessage(), 'doesn\'t exist') !== false) {
            // do setup the database

            $conn->executeTextStatement('CREATE TABLE IF NOT EXISTS `modules` (
  `id`               INT(5)       NOT NULL AUTO_INCREMENT,
  `key`              VARCHAR(100) NOT NULL,
  `namespace`        VARCHAR(100) NOT NULL,
  `fc_action`        VARCHAR(100) NOT NULL,
  `menu_template`    VARCHAR(100) NOT NULL,
  `content_template` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
)
  ENGINE =MyISAM
  DEFAULT CHARSET =utf8');

            $conn->executeTextStatement('INSERT INTO `modules` (
  `id`,
  `key`,
  `namespace`,
  `fc_action`,
  `menu_template`,
  `content_template`
) VALUES (
  1,
  \'news\',
  \'APF\\\\examples\\\\dynamicmodules\\\\modules\\\\news\',
  \'NewsAction\',
  \'navi\',
  \'content\'
);');

            $this->getResponse()->forward(LinkGenerator::generateUrl(Url::fromCurrent()));
         } else {
            // display database setup wizzard in case of any database-related errors
            $model->setNamespace('EXAMPLE\dynamicmodules\modules\wizzard\templates');
            $model->setNaviView(null);
            $model->setContentView('database_wizzard');
         }

      }

   }

}
