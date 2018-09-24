<?php
namespace SB\pres\controller;

use APF\core\configuration\ConfigurationException;
use APF\core\database\ConnectionManager;
use APF\core\database\MySQLiHandler;
use APF\core\pagecontroller\BaseDocumentController;

class DatabaseContentController extends BaseDocumentController {

   private static $CONFIG_SECTION_NAME = 'Sandbox-MySQL';

   private static $TABLE_NAME = 'sandbox_content';

   public function transformContent() {

      $urlName = $this->getRequest()->getParameter('name');
      $this->setPlaceHolder('urlname', $urlName);

      // in case the page is called from the template wizard and no configuration is
      // created, display a note instead of an exception
      try {

         $conn = $this->getConnection();

         $urlName = $conn->escapeValue($urlName);
         $select = 'SELECT * FROM `' . self::$TABLE_NAME . '` WHERE `urlname` = \'' . $urlName . '\'';
         $data = $conn->fetchData($conn->executeTextStatement($select));

         if ($data === false) {
            $tmpl = $this->getTemplate('no-content');
            $tmpl->transformOnPlace();

            return;
         }

         $tmpl = $this->getTemplate('content');
         $tmpl->setPlaceHolder('content', $data['content']);
         $tmpl->transformOnPlace();

      } catch (ConfigurationException $e) {
         $this->getTemplate('no-config')->transformOnPlace();
      }

   }

   /**
    * @return MySQLiHandler The database connection.
    */
   private function &getConnection() {
      return $this->getServiceObject(ConnectionManager::class)->getConnection(self::$CONFIG_SECTION_NAME);
   }

}
