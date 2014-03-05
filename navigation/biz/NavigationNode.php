<?php
namespace APF\examples\navigation\biz;

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
    * @return NavigationNode
    */
   public function getParent();

   /**
    * @return NavigationNode[]
    */
   public function getChildren();

}
