<?php
namespace EXAMPLE\navigation\pres\example\controller;

use APF\core\pagecontroller\BaseDocumentController;
use EXAMPLE\navigation\biz\SimpleNavigationNode;
use EXAMPLE\navigation\pres\taglibs\NavigationNodeTag;

class NavigationTagExampleController extends BaseDocumentController {

   public function transformContent() {

      $root = new SimpleNavigationNode(null, null, null);
      $levelOne = new SimpleNavigationNode('Level 1', '#');

      $root->setChildren([
            clone $levelOne->setInactive(),
            clone $levelOne->setActive(),
            clone $levelOne->setInactive()
      ]);

      /* @var $navi NavigationNodeTag */
      $navi = $this->getDocument()->getChildNode('id', 'main-navi', 'NavigationNodeTag');
      $navi->setNode($root);
   }
}
