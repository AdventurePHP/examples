<?php
namespace APP\sandbox\pres\controller;

use APF\core\loader\RootClassLoader;
use APF\core\pagecontroller\BaseDocumentController;

/**
 * @package APP\sandbox\pres\controller
 * @class DifferentClassLoaderTestController
 *
 * Demonstrates the class loading capabilities of the APF 2.0.
 *
 * @author Christian Achatz
 * @version
 * Version 0.1, 28.03.2013<br />
 */
class DifferentClassLoaderTestController extends BaseDocumentController {

   public function transformContent() {
      $loader = RootClassLoader::getLoaderByNamespace(__NAMESPACE__);
      $this->setPlaceHolder('root-path', $loader->getRootPath());

      $this->setPlaceHolder('controller-dir', dirname(__FILE__));

      $apfLoader = RootClassLoader::getLoaderByVendor('APF');
      $this->setPlaceHolder('apf-root-path', $apfLoader->getRootPath());
   }

}