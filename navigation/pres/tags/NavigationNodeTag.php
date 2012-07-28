<?php
import('examples::navigation::pres::tags', 'NavigationItemTag');
import('examples::navigation::pres::tags', 'NavigationContentTag');

class NavigationNodeTag extends Document {

   /**
    * @var NavigationNode The navigation node to display.
    */
   private $node;

   public function __construct() {
      $this->__TagLibs = array(
         new TagLib('examples::navigation::pres::tags', 'NavigationItemTag', 'navi', 'item'),
         new TagLib('examples::navigation::pres::tags', 'NavigationContentTag', 'navi', 'content')
      );
   }

   /**
    * @param NavigationNode $node The current navigation node to display.
    */
   public function setNode(NavigationNode $node) {
      $this->node = $node;
   }

   public function onParseTime() {
      $this->__extractTagLibTags();
   }

   public function transform() {

      $buffer = '';

      $navigationNodes = $this->node->getChildren();
      if (count($navigationNodes) > 0) {
         foreach ($navigationNodes as $node) {
            $buffer .= $this
                  ->getTemplate($node->isActive() ? 'active' : 'inactive')
                  ->getOutput($node);
         }
      }

      $content = $this->getContent();
      $children = &$this->getChildren();
      foreach ($children as $objectId => $DUMMY) {
         if ($children[$objectId] instanceof NavigationContentTag) {
            // fill the <navi:content /> place holder if we get him
            $content = str_replace('<' . $objectId . ' />', $buffer, $content);
         } else {
            // replace parser marker to avoid direct tag output
            $content = str_replace('<' . $objectId . ' />', '', $content);
         }
      }

      return $content;
   }

   /**
    * @param int $status
    * @return NavigationItemTag
    */
   private function getTemplate($status) {
      return $this->getChildNode('status', $status, 'NavigationItemTag');
   }

}
