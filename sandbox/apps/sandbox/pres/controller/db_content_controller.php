<?php
   import('tools::request', 'RequestHandler');

   class db_content_controller extends base_controller {

      private static $CONFIG_SECTION_NAME = 'Sandbox-MySQL';

      private static $TABLE_NAME = 'sandbox_content';
      
      public function transformContent() {

         $urlName = RequestHandler::getValue('name');
         $this->setPlaceHolder('urlname', $urlName);

         $conn = &$this->getConnection();

         $urlName = $conn->escapeValue($urlName);
         $select = 'SELECT * FROM `'.self::$TABLE_NAME.'` WHERE `urlname` = \''.$urlName.'\'';
         $data = $conn->fetchData($conn->executeTextStatement($select));
         
         if($data === false){
            $tmpl = &$this->__getTemplate('no-content');
            $tmpl->transformOnPlace();
            return;
         }

         $tmpl = &$this->__getTemplate('content');
         $tmpl->setPlaceHolder('content', $data['content']);
         $tmpl->transformOnPlace();

      }

      /**
       * @return MySQLxHandler The database connection.
       */
      private function &getConnection(){
         return $this->__getServiceObject('core::database', 'ConnectionManager')->getConnection(self::$CONFIG_SECTION_NAME);
      }

   }
?>