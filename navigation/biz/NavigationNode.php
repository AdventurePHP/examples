<?php
namespace EXAMPLE\navigation\biz;

interface NavigationNode {

   /**
    * @return string
    */
   public function getLabel();

   /**
    * @return string
    */
   public function getUrl();

   /**
    * @return bool
    */
   public function isActive();

   /**
    * @return NavigationNode
    */
   public function getParent();

   /**
    * @return NavigationNode[]
    */
   public function getChildren();

}
