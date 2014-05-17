<?php
namespace EXAMPLE\navigation\pres\taglibs;

use APF\core\pagecontroller\Document;
use EXAMPLE\navigation\biz\NavigationNode;

class ItemTemplateContentTag extends Document {

   /**
    * @var NavigationNode
    */
   private $node;

   public function setNode(NavigationNode $node) {
      $this->node = $node;
      return $this;
   }

   public function transform() {
      if ($this->node === null) {
         return '';
      }
      return '<a href="' . $this->node->getUrl() . '">' . $this->node->getLabel() . '</a>';
   }

}
