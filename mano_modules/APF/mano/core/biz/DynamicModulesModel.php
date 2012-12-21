<?php
class DynamicModulesModel {

   private $key = 'default';
   private $namespace = 'mano::core::pres::templates';
   private $naviView = 'navi';
   private $contentView = 'content';

   public function getKey() {
      return $this->key;
   }

   public function setKey($key) {
      $this->key = $key;
   }

   public function getNamespace() {
      return $this->namespace;
   }

   public function setNamespace($namespace) {
      $this->namespace = $namespace;
   }

   public function getNaviView() {
      return $this->naviView;
   }

   public function setNaviView($naviView) {
      $this->naviView = $naviView;
   }

   public function getContentView() {
      return $this->contentView;
   }

   public function setContentView($contentView) {
      $this->contentView = $contentView;
   }

}
