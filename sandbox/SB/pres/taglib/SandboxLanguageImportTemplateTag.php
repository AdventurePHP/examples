<?php
namespace SB\pres\taglib;

use APF\core\pagecontroller\ImportTemplateTag;

/**
 * @package SB\pres\taglib
 * @class SandboxLanguageImportTemplateTag
 *
 * Implements a special tag lib to import language templates from
 * a prefixed namespace.
 */
class SandboxLanguageImportTemplateTag extends ImportTemplateTag {

   public function onParseTime() {
      // re-maps the namespace to the language dependent sub-path
      // to be able to save the content within language dependent
      // templates under the "normal" namespace.
      $this->setAttribute(
         'namespace',
            $this->getAttribute('namespace') . '\\' . $this->getLanguage()
      );
      parent::onParseTime();
   }

}