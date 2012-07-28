<?php
import('examples::navigation::biz', 'SimpleNavigationNode');

class NavigationTagExampleController extends base_controller {
   public function transformContent() {

      $root = new SimpleNavigationNode(null, null, null);
      $levelOne = new SimpleNavigationNode('Level 1', '#');

      $root->setChildren(array(
         clone $levelOne->setInactive(),
         clone $levelOne->setActive(),
         clone $levelOne->setInactive()
      ));

      /* @var $navi NavigationNodeTag */
      $navi = $this->getDocument()->getChildNode('id', 'main-navi', 'NavigationNodeTag');
      $navi->setNode($root);
   }
}
