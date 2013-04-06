<?php
namespace APF\sandbox\pres\controller;

use APF\core\configuration\ConfigurationException;
use APF\core\configuration\provider\ini\IniConfiguration;
use APF\core\database\AbstractDatabaseHandler;
use APF\core\pagecontroller\BaseDocumentController;
use APF\modules\genericormapper\data\tools\GenericORMapperManagementTool;
use APF\modules\usermanagement\biz\UmgtManager;
use APF\modules\usermanagement\biz\model\UmgtApplication;
use APF\modules\usermanagement\biz\model\UmgtUser;
use APF\tools\http\HeaderManager;

class UserManagementWizzardController extends BaseDocumentController {

   private static $CONFIG_SECTION_NAME = 'Sandbox-UMGT';
   private static $CONFIG_SUB_SECTION_NAME = 'DB';

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

         $section = new IniConfiguration();
         $section->setValue('Host', $host);
         $section->setValue('User', $user);
         $section->setValue('Pass', $pass);
         $section->setValue('Name', $name);
         $section->setValue('Port', $port);
         $section->setValue('Collation', 'utf8_general_ci');
         $section->setValue('Charset', 'utf8');
         $section->setValue('Type', 'MySQLx');

         $dbSection->setSection(self::$CONFIG_SUB_SECTION_NAME, $section);

         // load existing configuration or create new one
         try {
            $config = $this->getConfiguration('APF\core\database', 'connections.ini');
         } catch (ConfigurationException $e) {
            $config = new IniConfiguration();
         }

         $config->setSection(self::$CONFIG_SECTION_NAME, $dbSection);
         $this->saveConfiguration('APF\core\database', 'connections.ini', $config);

         HeaderManager::forward('./?page=umgt-wizzard#step-2');
         return;
      }

      $configAvailable = false;
      $subSection = null;
      try {
         $config = $this->getConfiguration('APF\core\database', 'connections.ini');
         $tmpl = & $this->getTemplate('db-config-exists');

         $section = $config->getSection(self::$CONFIG_SECTION_NAME);
         if ($section == null) {
            throw new ConfigurationException('Section "' . self::$CONFIG_SECTION_NAME
                  . '" is not contained in the current configuration!', E_USER_ERROR);
         }
         $subSection = $section->getSection(self::$CONFIG_SUB_SECTION_NAME);

         $tmpl->setPlaceHolder('host', $subSection->getValue('Host'));
         $tmpl->setPlaceHolder('port', $subSection->getValue('Port'));
         $tmpl->setPlaceHolder('user', $subSection->getValue('User'));
         $tmpl->setPlaceHolder('pass', $subSection->getValue('Pass'));
         $tmpl->setPlaceHolder('name', $subSection->getValue('Name'));
         $tmpl->setPlaceHolder('collation', $subSection->getValue('Collation'));
         $tmpl->setPlaceHolder('charset', $subSection->getValue('Charset'));
         $tmpl->setPlaceHolder('type', $subSection->getValue('Type'));

         $tmpl->transformOnPlace();

         $configAvailable = true;
      } catch (ConfigurationException $e) {
         $formNewConfig->transformOnPlace();
      }

      // step 2: create database layout
      $databaseLayoutInitialized = false;
      if ($configAvailable) {

         $formInitDb = & $this->getForm('init-db');
         try {
            $conn = $this->getServiceObject('APF\core\database\ConnectionManager')
                  ->getConnection(self::$CONFIG_SECTION_NAME);
            /* @var $conn AbstractDatabaseHandler */

            // check for db layout...
            $result = $conn->executeTextStatement('SHOW TABLES');
            $setupDone = false;
            $offsetName = 'Tables_in_' . $subSection->getValue('Name');
            while ($data = $conn->fetchData($result)) {
               if ($data[$offsetName] == 'ent_user') {
                  $setupDone = true;
               }
            }

            if ($setupDone) {
               $this->getTemplate('tables-exist')->transformOnPlace();
               $databaseLayoutInitialized = true;
            } else {
               if ($formInitDb->isSent()) {

                  // setup database layout
                  /* @var $setup GenericORMapperManagementTool */
                  $setup = & $this->getServiceObject('APF\modules\genericormapper\data\tools\GenericORMapperManagementTool');
                  $setup->addMappingConfiguration('modules::usermanagement::data', 'umgt');
                  $setup->addRelationConfiguration('modules::usermanagement::data', 'umgt');
                  $setup->setConnectionName(self::$CONFIG_SECTION_NAME);
                  $setup->run();

                  // initialize application
                  $umgt = & $this->getUmgtManager();
                  $app = new UmgtApplication();
                  $app->setDisplayName('Sandbox');
                  $umgt->saveApplication($app);

                  HeaderManager::forward('?page=umgt-wizzard#step-3');
               } else {
                  $formInitDb->transformOnPlace();
               }
            }
         } catch (\Exception $e) {
            $tmplDbConnErr = & $this->getTemplate('db-conn-error');
            $tmplDbConnErr->setPlaceHolder('exception', $e->getMessage());
            $tmplDbConnErr->transformOnPlace();
         }
      } else {
         $this->getTemplate('step-1-req')->transformOnPlace();
      }

      // step 3: initialize "root" user
      $initialUserCreated = false;
      if ($databaseLayoutInitialized) {

         $formCreateUser = & $this->getForm('create-user');

         $umgt = & $this->getUmgtManager();

         if ($formCreateUser->isSent() && $formCreateUser->isValid()) {

            $username = $formCreateUser->getFormElementByName('username')->getAttribute('value');
            $password = $formCreateUser->getFormElementByName('password')->getAttribute('value');

            $user = new UmgtUser();
            $user->setUsername($username);
            $user->setPassword($password);

            // assume typical user attributes to have valid display in mgmt backend!
            $user->setFirstName($username);
            $user->setLastName($username);
            $user->setDisplayName($username);

            $umgt->saveUser($user);

            HeaderManager::forward('?page=umgt-wizzard#step-3');
         } else {

            // display user list to note the user
            $userListTmpl = & $this->getTemplate('user-list');

            $users = $umgt->getPagedUserList();

            if (count($users) > 0) {

               // indicate that step 4 may be activated
               $initialUserCreated = true;

               $buffer = '';
               foreach ($users as $user) {
                  $buffer .= '<li>' . $user->getUsername() . '</li>' . PHP_EOL;
               }

               $userListTmpl->setPlaceHolder('user-list-entries', $buffer);
               $userListTmpl->transformOnPlace();
            }

            $formCreateUser->transformOnPlace();
         }
      } else {
         $this->getTemplate('step-2-req')->transformOnPlace();
      }

      // step 4: call umgt backend
      if ($initialUserCreated) {
         $this->getTemplate('step-4')->transformOnPlace();
      } else {
         $this->getTemplate('step-3-req')->transformOnPlace();
      }
   }

   /**
    * @return UmgtManager The instance of the current umgt manager.
    */
   private function &getUmgtManager() {
      return $this->getDIServiceObject('APF\modules\usermanagement\biz', 'UmgtManager');
   }

}
