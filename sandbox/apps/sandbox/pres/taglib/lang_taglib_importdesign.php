<?php
   class lang_taglib_importdesign extends core_taglib_importdesign {

      public function onParseTime() {
         // re-maps the namespace to the language dependent sub-path
         // to be able to save the content within language dependent
         // templates under the "normal" namespace.
         $this->setAttribute(
                 'namespace',
                 $this->getAttribute('namespace') . '::' . $this->getLanguage()
         );
         parent::onParseTime();
      }

   }
?>