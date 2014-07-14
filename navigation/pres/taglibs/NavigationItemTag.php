<?php
namespace EXAMPLE\navigation\pres\taglibs;

use APF\core\pagecontroller\Document;
use EXAMPLE\navigation\biz\NavigationNode;

class NavigationItemTag extends Document {

   public function __construct() {
      self::addTagLib('EXAMPLE\navigation\pres\taglibs\ItemTemplateContentTag', 'item', 'content');
   }

   public function onParseTime() {
      $this->extractTagLibTags();
   }

   public function getOutput(NavigationNode $node) {
      $content = $this->getContent();
      $children = & $this->getChildren();
      foreach ($children as $objectId => $DUMMY) {
         if ($children[$objectId] instanceof ItemTemplateContentTag) {
            // fill the <item:content /> place holder if we get him
            $content = str_replace('<' . $objectId . ' />', $children[$objectId]->setNode($node)->transform(), $content);
         } else {
            // replace parser marker to avoid direct tag output
            $content = str_replace('<' . $objectId . ' />', '', $content);
         }
      }
      return $content;
   }

   public function transform() {
      return '';
   }

}
