<?php
// initialize language if is is sent by the browser
define('APPS__PATH', 'D:\Apache2.2\htdocs\www\sandbox-2.0\apps');

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

   /**
    * @public
    *
    * Returns the root path this class loader instance uses to load PHP classes.
    * <p/>
    * Further, tha root path is used to load templates and configuration files as well.
    * This is because the APF uses one addressing scheme for all elements. Please note,
    * that templates and configuration files naturally do not have namespaces but the
    * APF introduces them with this mechanism for convenience and consistency reasons.
    *
    * @return string The root path of the class loader.
    *
    * @author Christian Achatz
    * @version
    * Version 0.1, 20.03.2013<br />
    */
   public function getRootPath();

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

   public function getRootPath() {
      return $this->rootPath;
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

   /**
    * @param ClassLoader $loader A class loader to add to the list.
    */
   public static function addLoader(ClassLoader $loader) {
      self::$loaders[$loader->getVendorName()] = $loader;
   }

   public static function load($class) {
      // try to load class for each loader
      foreach (self::$loaders as $loader) {
         $loader->load($class);
      }
   }

   /**
    * @param string $vendorName The name of the desired class loader to get.
    * @return ClassLoader The desired class loader.
    * @throws \Exception In case no class loader is found.
    */
   public static function getLoaderByVendor($vendorName) {
      if (isset(self::$loaders[$vendorName])) {
         return self::$loaders[$vendorName];
      }
      throw new \Exception('No class loader with vendor "' . $vendorName . '" registered!');
   }

   // ? do we need this?
   public static function getLoaderByNamespace($namespace) {
      return self::getLoaderByVendor(substr($namespace, 0, strpos($namespace, '\\')));
   }

}

// Class loader is just one thing, because it doesn't load templates and configs!
// Hence, we need a combination of class loader, template loader, and config loader root path.
// --> Templates must be loaded with full Vendor-based class path, then vendor class loader concept
RootClassLoader::addLoader(new VendorBasedClassLoader('APF', APPS__PATH));
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

echo $fC->start('APF\sandbox\pres\templates', 'main');

use APF\core\benchmark\BenchmarkTimer;

/* @var $t APF\core\benchmark\BenchmarkTimer */
$t = & Singleton::getInstance('APF\core\benchmark\BenchmarkTimer');
if (isset($_REQUEST['benchmark']) && $_REQUEST['benchmark'] == 'true') {
   echo $t->createReport();
}
echo '<!--' . $t->getTotalTime() . '-->';