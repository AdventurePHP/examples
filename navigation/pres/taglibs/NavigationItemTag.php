<?php
namespace EXAMPLE\navigation\pres\taglibs;

use APF\core\pagecontroller\Document;
use EXAMPLE\navigation\biz\NavigationNode;

class NavigationItemTag extends Document {

   public function __construct() {
      self::addTagLib(ItemTemplateContentTag::clearTemplateExpressions(), 'item', 'content');
   }

   public function onParseTime() {
      $this->extractTagLibTags();
   }

   public function getOutput(NavigationNode $node) {
      $content = $this->getContent();

      foreach ($this->getChildren() as &$child) {
          if ($child instanceof ItemTemplateContentTag) {
              // fill the <item:content /> place holder if we get him
              $content = str_replace('<' . $child->getObjectId() . ' />', $child->setNode($node)->transform(), $content);
          } else {
              // replace parser marker to avoid direct tag output
              $content = str_replace('<' . $child->getObjectId() . ' />', '', $content);
          }
      }

      return $content;
   }

   public function transform() {
      return '';
   }

}
