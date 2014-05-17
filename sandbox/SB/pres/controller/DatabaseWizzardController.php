<?php
namespace SB\pres\controller;

use APF\core\configuration\ConfigurationException;
use APF\core\configuration\provider\ini\IniConfiguration;
use APF\core\database\AbstractDatabaseHandler;
use APF\core\database\DatabaseHandlerException;
use APF\core\pagecontroller\BaseDocumentController;
use APF\core\registry\Registry;
use APF\tools\http\HeaderManager;

class DatabaseWizzardController extends BaseDocumentController {

   private static $CONFIG_SECTION_NAME = 'Sandbox-MySQL';
   private static $TABLE_NAME = 'sandbox_content';

   public function transformContent() {

      // step 1: create database config file
      $formNewConfig = & $this->getForm('new-db-config');

      if ($formNewConfig->isSent() && $formNewConfig->isValid()) {

         // retrieve the form values
         $host = $formNewConfig->getFormElementByName('db-host')->getAttribute('value');
         $port = $formNewConfig->getFormElementByName('db-port')->getAttribute('value');
         $user = $formNewConfig->getFormElementByName('db-user')->getAttribute('value');
         $pass = $formNewConfig->getFormElementByName('db-pass')->getAttribute('value');
         $name = $formNewConfig->getFormElementByName('db-name')->getAttribute('value');

         // create configuration and save it!
         $dbSection = new IniConfiguration();

         $dbSection->setValue('Host', $host);
         $dbSection->setValue('User', $user);
         $dbSection->setValue('Pass', $pass);
         $dbSection->setValue('Name', $name);
         $dbSection->setValue('Port', $port);
         $dbSection->setValue('Collation', 'utf8_general_ci');
         $dbSection->setValue('Charset', 'utf8');
         $dbSection->setValue('Type', 'APF\core\database\MySQLiHandler');

         // load existing configuration or create new one
         try {
            $config = $this->getConfiguration('APF\core\database', 'connections.ini');
         } catch (ConfigurationException $e) {
            $config = new IniConfiguration();
         }

         $config->setSection(self::$CONFIG_SECTION_NAME, $dbSection);
         $this->saveConfiguration('APF\core\database', 'connections.ini', $config);

         HeaderManager::forward('./?page=db-wizzard#step-2');

         return;
      }

      $configAvailable = false;
      try {
         $config = $this->getConfiguration('APF\core\database', 'connections.ini');
         $tmpl = & $this->getTemplate('db-config-exists');

         $section = $config->getSection(self::$CONFIG_SECTION_NAME);
         if ($section == null) {
            throw new ConfigurationException('Section "' . self::$CONFIG_SECTION_NAME
                  . '" is not contained in the current configuration!', E_USER_ERROR);
         }


         $tmpl->setPlaceHolder('host', $section->getValue('Host'));
         $tmpl->setPlaceHolder('port', $section->getValue('Port'));
         $tmpl->setPlaceHolder('user', $section->getValue('User'));
         $tmpl->setPlaceHolder('pass', $section->getValue('Pass'));
         $tmpl->setPlaceHolder('name', $section->getValue('Name'));
         $tmpl->setPlaceHolder('collation', $section->getValue('Collation'));
         $tmpl->setPlaceHolder('charset', $section->getValue('Charset'));
         $tmpl->setPlaceHolder('type', $section->getValue('Type'));

         $tmpl->transformOnPlace();

         $configAvailable = true;
      } catch (ConfigurationException $e) {
         $formNewConfig->transformOnPlace();
      }

      // step 2: create the database table
      $conn = null;
      $tableExists = false;
      if ($configAvailable) {

         $conn = & $this->getConnection();

         // evaluate, whether the table is already existing
         try {
            $select = 'SHOW TABLES';

            $result = $conn->executeTextStatement($select);
            while ($data = $conn->fetchData($result)) {
               $keys = array_keys($data);
               if (self::$TABLE_NAME == $data[$keys[0]]) {
                  $tableExists = true;
               }
            }

            if ($tableExists) {
               $this->getTemplate('table-exists')->transformOnPlace();
            } else {
               $create = 'CREATE TABLE `' . self::$TABLE_NAME . '` (
`id` INT(5) NOT NULL AUTO_INCREMENT,
`urlname` VARCHAR(30) NOT NULL,
`content` TEXT NOT NULL,
PRIMARY KEY (`id`),
UNIQUE (`urlname`)
) ENGINE = MYISAM;';

               $formCreateTable = & $this->getForm('create-table');

               if ($formCreateTable->isSent()) {
                  $conn->executeTextStatement($create);

                  // add initial text
                  $insert = 'INSERT INTO `' . self::$TABLE_NAME . '` (`urlname`, `content`) VALUES (\'hello-world\', \'This is displayed on the hello-world page. / Dieser Text wird auf der Hallo-Welt!-Seite angezeigt.\');';
                  $conn->executeTextStatement($insert);

                  HeaderManager::forward('./?page=db-wizzard#step-3');
               } else {
                  $tmpl = & $this->getTemplate('step-2');
                  $tmpl->setPlaceHolder('statement', $create);
                  $tmpl->transformOnPlace();

                  $formCreateTable->transformOnPlace();
               }
            }
         } catch (DatabaseHandlerException $e) {
            $tmpl = & $this->getTemplate('db-conn-error');
            $tmpl->setPlaceHolder('exception', $e->getMessage());
            $tmpl->transformOnPlace();
         }
      } else {
         $this->getTemplate('step-1-req')->transformOnPlace();
      }

      // step 3: create some contents
      if ($configAvailable && $tableExists) {

         // display entry text
         $this->getTemplate('step-3')->transformOnPlace();

         // handle for behaviour
         $formCreateContent = & $this->getForm('add-content');
         if ($formCreateContent->isSent() && $formCreateContent->isValid()) {

            $urlName = $formCreateContent->getFormElementByName('content-urlname')->getAttribute('value');
            $content = $formCreateContent->getFormElementByName('content-text')->getContent();

            $content = $conn->escapeValue(html_entity_decode($content, ENT_QUOTES, Registry::retrieve('APF\core', 'Charset')));

            $insert = 'INSERT INTO `' . self::$TABLE_NAME . '` (`urlname`, `content`) VALUES (\'' . $urlName . '\', \'' . $content . '\');';
            $conn->executeTextStatement($insert);

            HeaderManager::forward('./?page=db-wizzard#step-4');
         }

         $formCreateContent->transformOnPlace();
      } else {
         $this->getTemplate('step-1-2-req')->transformOnPlace();
      }

      // step 4: display content
      if ($configAvailable && $tableExists) {

         $tmpl = & $this->getTemplate('step-4');

         $select = 'SELECT * FROM `' . self::$TABLE_NAME . '` ORDER BY `urlname` ASC';
         $result = $conn->executeTextStatement($select);

         $buffer = '';
         while ($data = $conn->fetchData($result)) {
            $buffer .= '<li><a href="?page=db-content&name=' . $data['urlname'] . '">' . $data['urlname'] . '</a></li>';
         }

         $tmpl->setPlaceHolder('pages', $buffer);

         $tmpl->transformOnPlace();
      } else {
         $this->getTemplate('step-1-2-3-req')->transformOnPlace();
      }
   }

   /**
    * @return AbstractDatabaseHandler The database connection.
    */
   private function &getConnection() {
      return $this->getServiceObject('APF\core\database\ConnectionManager')->getConnection(self::$CONFIG_SECTION_NAME);
   }

}
