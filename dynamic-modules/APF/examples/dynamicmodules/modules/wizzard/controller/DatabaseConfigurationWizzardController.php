<?php
namespace APF\examples\dynamicmodules\modules\wizzard\controller;

use APF\core\database\ConnectionManager;
use APF\core\pagecontroller\BaseDocumentController;
use APF\tools\http\HeaderManager;
use APF\tools\link\LinkGenerator;
use APF\tools\link\Url;

class DatabaseConfigurationWizzardController extends BaseDocumentController {

   public function transformContent() {

      $form = $this->getForm('database-credentials');

      $config = $this->getConfiguration('APF\core\database', 'connections.ini');
      $section = $config->getSection('MySQL')->getSection('DB');

      $host = $form->getFormElementByName('host');
      $port = $form->getFormElementByName('port');
      $name = $form->getFormElementByName('name');
      $user = $form->getFormElementByName('user');
      $pass = $form->getFormElementByName('pass');

      if ($form->isSent()) {
         if ($form->isValid()) {

            // update configuration
            $section->setValue('Host', $host->getValue());
            $section->setValue('Port', $port->getValue());
            $section->setValue('Name', $name->getValue());
            $section->setValue('User', $user->getValue());
            $section->setValue('Pass', $pass->getValue());

            $this->saveConfiguration('APF\core\database', 'connections.ini', $config);

            // reload page to let the change take effect
            HeaderManager::forward(LinkGenerator::generateUrl(Url::fromCurrent()));
         } else {
            $form->transformOnPlace();
         }
      } else {

         // pre-fill
         $host->setValue($section->getValue('Host'));
         $port->setValue($section->getValue('Port'));
         $name->setValue($section->getValue('Name'));
         $user->setValue($section->getValue('User'));
         $pass->setValue($section->getValue('Pass'));

         $form->transformOnPlace();
      }

   }

}