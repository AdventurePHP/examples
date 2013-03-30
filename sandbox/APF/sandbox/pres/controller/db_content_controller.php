<?php
namespace APF\sandbox\pres\controller;

use APF\core\configuration\ConfigurationException;
use APF\core\database\MySQLxHandler;
use APF\core\pagecontroller\BaseDocumentController;
use APF\tools\request\RequestHandler;

class db_content_controller extends BaseDocumentController {

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
    * @return MySQLxHandler The database connection.
    */
   private function &getConnection() {
      return $this->getServiceObject('core::database', 'ConnectionManager')->getConnection(self::$CONFIG_SECTION_NAME);
   }

}
