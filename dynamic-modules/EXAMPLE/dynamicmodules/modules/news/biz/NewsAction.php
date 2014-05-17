<?php
namespace EXAMPLE\dynamicmodules\modules\news\biz;

use APF\core\frontcontroller\AbstractFrontcontrollerAction;

class NewsAction extends AbstractFrontcontrollerAction {
   public function run() {
      echo 'I\'am the news module action...';
   }
}