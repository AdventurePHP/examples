<?php
namespace SB\pres\controller;

use APF\core\configuration\ConfigurationException;
use APF\core\database\MySQLiHandler;
use APF\core\pagecontroller\BaseDocumentController;
use APF\tools\request\RequestHandler;

class DatabaseContentController extends BaseDocumentController {

   private static $CONFIG_SECTION_NAME = 'Sandbox-MySQL';

   private static $TABLE_NAME = 'sandbox_content';

   public function transformContent() {

      $urlName = RequestHandler::getValue('name');
      $this->setPlaceHolder('urlname', $urlName);

      // in case the page is called from the template wizzard and no configuration is
      // created, display a note instead of an exception
      try {

         $conn = & $this->getConnection();

         $urlName = $conn->escapeValue($urlName);
         $select = 'SELECT * FROM `' . self::$TABLE_NAME . '` WHERE `urlname` = \'' . $urlName . '\'';
         $data = $conn->fetchData($conn->executeTextStatement($select));

         if ($data === false) {
            $tmpl = & $this->getTemplate('no-content');
            $tmpl->transformOnPlace();
            return;
         }

         $tmpl = & $this->getTemplate('content');
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
      return $this->getServiceObject('APF\core\database\ConnectionManager')->getConnection(self::$CONFIG_SECTION_NAME);
   }

}
