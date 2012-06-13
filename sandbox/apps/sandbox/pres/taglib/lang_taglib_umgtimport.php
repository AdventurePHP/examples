<?php
/**
 * @package sandbox::pres::taglib
 * @class lang_taglib_umgtimport
 *
 * Implements a special tag lib to import language templates from
 * a prefixed namespace.
 */
class lang_taglib_umgtimport extends core_taglib_importdesign {

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