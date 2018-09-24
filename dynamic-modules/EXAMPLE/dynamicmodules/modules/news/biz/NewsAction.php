<?php
namespace EXAMPLE\dynamicmodules\modules\news\biz;

use APF\core\frontcontroller\AbstractFrontControllerAction;

class NewsAction extends AbstractFrontControllerAction {
   public function run() {
      echo 'I\'am the news module action...';
   }
}