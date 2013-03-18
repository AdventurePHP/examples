<?php
// initialize language if is is sent by the browser
$lang = 'en';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && substr_count($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de') > 0) {
   $lang = 'de';
}

// configure PHP's error message type
ini_set('html_errors', 'off');


interface ClassLoader {

   /**
    * Decision on what to do with none-vendor classes can be done by the ClassLoader itself!
    *
    * @param string $class The class to load.
    */
   public function load($class);

   /**
    * @return string The name of the vendor the class loader is attending to.
    */
   public function getVendorName();

}

class VendorBasedClassLoader implements ClassLoader {

   private $vendorName = 'APF';

   private $rootPath;

   private $autoLoaderExceptions = array(
      'APF\core\pagecontroller',
      'APF\core\configuration\ConfigurationProvider',
      'APF\core\configuration\ConfigurationException',
      'APF\tools\link\Url'
   );

   public function __construct($vendorName, $rootPath) {
      $this->vendorName = $vendorName;
      $this->rootPath = $rootPath;
   }

   public function load($class) {
      file_put_contents(__FUNCTION__ . '.log', date('[Y-m-d H:i:s] ') . $class . PHP_EOL, FILE_APPEND);

      if (strpos($class, $this->vendorName . '\\') !== false) {

         // check if the file is already included, if yes, return
         if (isset($GLOBALS['IMPORT_CACHE'][$class])) {
            return;
         } else {
            $GLOBALS['IMPORT_CACHE'][$class] = true;
         }

         foreach ($this->autoLoaderExceptions as $item) {
            if (strpos($class, $item) !== false) {
               return;
            }
         }

         // create the complete and absolute file name
         $strippedClass = str_replace($this->vendorName . '\\', '', $class);
         $file = $this->rootPath . '/' . str_replace('\\', '/', $strippedClass) . '.php';

         // do a file_exists() instead of @include() because fatal errors must not be caught here (e.g. class not found)!
         if (file_exists($file)) {
            include($file);
         } else {
            //echo '<pre>' . print_r(array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)), true) . '</pre>';
            throw new APF\core\pagecontroller\IncludeException('[VendorBasedClassLoader::load()] Loading class "'
                  . $class . '" filed since file "' . $file . '" cannot be loaded!', E_USER_ERROR);
         }
      }
   }

   public function getVendorName() {
      return $this->vendorName;
   }

   public function setVendorName($name) {
      $this->vendorName = $name;
   }

   public function setRootPath($rootPath) {
      $this->rootPath = $rootPath;
   }

   protected function getVendorByClass($class) {
      return substr($class, 0, strpos($class, '\\'));
   }

}

class RootClassLoader {

   /**
    * @var ClassLoader[]
    */
   private static $loaders = array();

   public static function addLoader(ClassLoader $loader) {
      self::$loaders[$loader->getVendorName()] = $loader;
   }

   public static function load($class) {
      // try to load class for each loader
      foreach (self::$loaders as $loader) {
         $loader->load($class);
      }
   }

}

RootClassLoader::addLoader(new VendorBasedClassLoader('APF', 'D:/Apache2.2/htdocs/www/ns-poc/apps'));
spl_autoload_register(array('RootClassLoader', 'load'));

// include the pagecontroller
include_once('./apps/core/pagecontroller/pagecontroller.php');

// prepare logger for different database drivers
use APF\core\singleton\Singleton;

// create the sandbox page
use APF\core\frontcontroller\Frontcontroller;

$fC = & Singleton::getInstance('APF\core\frontcontroller\Frontcontroller');
/* @var $fC Frontcontroller */
$fC->setContext('myapp');
$fC->setLanguage($lang);

//$fC->registerAction('modules::usermanagement::biz', 'UmgtAutoLoginAction');

echo $fC->start('sandbox::pres::templates', 'main');

use APF\core\benchmark\BenchmarkTimer;

/* @var $t APF\core\benchmark\BenchmarkTimer */
$t = & Singleton::getInstance('APF\core\benchmark\BenchmarkTimer');
if (isset($_REQUEST['benchmark']) && $_REQUEST['benchmark'] == 'true') {
   echo $t->createReport();
}
echo '<!--' . $t->getTotalTime() . '-->';