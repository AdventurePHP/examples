<?php
import('examples::navigation::pres::tags', 'ItemTemplateContentTag');

class NavigationItemTag extends Document {

   public function __construct() {
      $this->tagLibs = array(
         new TagLib('examples::navigation::pres::tags', 'ItemTemplateContentTag', 'item', 'content')
      );
   }

   public function onParseTime() {
      $this->extractTagLibTags();
   }

   public function getOutput(NavigationNode $node) {
      $content = $this->getContent();
      $children = &$this->getChildren();
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
