<?php
namespace APF\sandbox\pres\controller;

use APF\core\pagecontroller\BaseDocumentController;
use APF\tools\http\HeaderManager;

class tmpl_wizzard_controller extends BaseDocumentController {

   public function transformContent() {

      // display pages for th current language
      $buffer = '';
      $files = glob(APPS__PATH . '/sandbox/pres/templates/' . $this->getLanguage() . '/content/*.html');
      foreach ($files as $file) {
         $fileName = basename($file);
         $urlName = str_replace('.html', '', $fileName);
         $buffer .= '<li><a href="?page=' . $urlName . '">' . basename($file) . '</a></li>';
      }
      $this->setPlaceHolder('existing-tmpl', $buffer);

      // handle and display form
      $form = &$this->getForm('new-page');

      if ($form->isSent() && $form->isValid()) {

         $filePath = APPS__PATH . '/sandbox/pres/templates/' . $this->getLanguage() . '/content/';

         $fileName = $form->getFormElementByName('tmpl-name')->getAttribute('value');
         $content = $form->getFormElementByName('tmpl-content')->getContent();

         file_put_contents($filePath . '/' . $fileName . '.html', html_entity_decode($content, ENT_QUOTES, Registry::retrieve('apf::core', 'Charset')));

         HeaderManager::forward('./?page=tmpl-wizzard');

      }

      $form->transformOnPlace();

   }

}
