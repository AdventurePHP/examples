<?php
   import('tools::cache','CacheManager');


   /**
   *  @namespace sites::vbc::pres::taglib
   *  @class cache_taglib_importdesign
   *
   *  Implements the view based caching taglib, based on the core:importdesign
   *  tag. The tag expects the following parameters:
   *  <ul>
   *    <li>namespace: the namespace of the template to include</li>
   *    <li>template: the name of the template to include</li>
   *    <li>cachekey: the cachekey used for caching</li>
   *    <li>cacheconfig: the cache configuration key</li>
   *  </ul>
   *
   *  @author Christian Achatz
   *  @version
   *  Version 0.1, 29.11.2008<br />
   */
   class cache_taglib_importdesign extends core_taglib_importdesign
   {

      /**
      *  @private
      *  Stores the cache content if applicable.
      */
      var $__CacheContent = null;


      /**
      *  @public
      *
      *  Call the parent's constructor to fill the known taglib list.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 29.11.2008<br />
      */
      function cache_taglib_importdesign(){
         parent::core_taglib_importdesign();
       // end function
      }


      /**
      *  @public
      *
      *  Reimplements the onParseTime() method. Validates the tag attributes and tries
      *  to fetch the content from the cache. If ni cache content is applicable, the
      *  parent class' functionality is called.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 29.11.2008<br />
      */
      function onParseTime(){

         // gather tag configuration
         $cacheConfig = $this->getAttribute('cacheconfig');
         $cacheKey = $this->getAttribute('cachekey');

         // get the cache manager
         $cMF = &$this->__getServiceObject('tools::cache','CacheManagerFabric');
         $cM = &$cMF->getCacheManager($cacheConfig);

         // clear the cache if desired
         if(isset($_REQUEST['clearcache']) && $_REQUEST['clearcache'] == 'true'){
           $cM->clearCache($cacheKey);
          // end if
         }

         // try to read from the cache
         $this->__CacheContent = $cM->getFromCache($cacheKey);

         // check if the document was cached before. If not
         // execute the parent's onParseTime()
         if($this->__CacheContent === null){
            parent::onParseTime();
          // end if
         }

       // end function
      }


      /**
      *  @public
      *
      *  Reimplements the transform() method. Returns the cache content loaded within the
      *  onParseTime() method or executes the parent class' functionality.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 29.11.2008<br />
      */
      function transform(){

         // generate the node's output or return the cached content
         if($this->__CacheContent === null){

            // gather tag configuration
            $cacheConfig = $this->getAttribute('cacheconfig');
            $cacheKey = $this->getAttribute('cachekey');

            // get the cache manager
            $cMF = &$this->__getServiceObject('tools::cache','CacheManagerFabric');
            $cM = &$cMF->getCacheManager($cacheConfig);

            // generate output and cache it
            $output = parent::transform();
            $cM->writeToCache($cacheKey,$output);

            // return the tag's output
            return $output;

          // end if
         }
         else{
            return $this->__CacheContent;
          // end else
         }

       // end function
      }

    // end class
   }
?>