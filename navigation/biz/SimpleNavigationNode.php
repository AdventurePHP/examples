<?php
namespace APF\examples\navigation\biz;

class SimpleNavigationNode implements NavigationNode {

   private $label;
   private $url;
   private $isActive = false;

   /**
    * @var NavigationNode
    */
   private $parent;

   /**
    * @var NavigationNode[]
    */
   private $children = array();

   public function __construct($label, $url) {
      $this->label = $label;
      $this->url = $url;
   }

   public function getLabel() {
      return $this->label;
   }

   public function getUrl() {
      return $this->url;
   }

   public function isActive() {
      return $this->isActive;
   }

   public function setActive() {
      $this->isActive = true;
      return $this;
   }

   public function setInactive() {
      $this->isActive = false;
      return $this;
   }

   public function getParent() {
      return $this->parent;
   }

   public function getChildren() {
      return $this->children;
   }

   public function setParent(NavigationNode $node) {
      $this->parent = $node;
   }

   public function setChildren(array $nodes) {
      $this->children = $nodes;
   }

}
