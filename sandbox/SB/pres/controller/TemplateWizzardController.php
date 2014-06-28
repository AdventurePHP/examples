<?php
namespace SB\pres\controller;

use APF\core\loader\RootClassLoader;
use APF\core\pagecontroller\BaseDocumentController;
use APF\core\registry\Registry;
use APF\tools\http\HeaderManager;

class TemplateWizzardController extends BaseDocumentController {

   public function transformContent() {

      // display pages for th current language
      $buffer = '';

      $rootPath = RootClassLoader::getLoaderByVendor('SB')->getRootPath();

      $files = glob($rootPath . '/pres/templates/' . $this->getLanguage() . '/content/*.html');
      foreach ($files as $file) {
         $fileName = basename($file);
         $urlName = str_replace('.html', '', $fileName);
         $buffer .= '<li><a href="?page=' . $urlName . '">' . basename($file) . '</a></li>';
      }
      $this->setPlaceHolder('existing-tmpl', $buffer);

      // handle and display form
      $form = & $this->getForm('new-page');

      if ($form->isSent() && $form->isValid()) {

         $filePath = $rootPath . '/pres/templates/' . $this->getLanguage() . '/content';

         $fileName = $form->getFormElementByName('tmpl-name')->getAttribute('value');
         $content = $form->getFormElementByName('tmpl-content')->getContent();

         file_put_contents($filePath . '/' . $fileName . '.html', html_entity_decode($content, ENT_QUOTES, Registry::retrieve('APF\core', 'Charset')));

         HeaderManager::forward('./?page=tmpl-wizzard');
      }

      $form->transformOnPlace();

   }

}
