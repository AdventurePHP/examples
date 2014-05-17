<?php
namespace SB\pres\taglib;

use APF\core\pagecontroller\Document;

/**
 * @package APF\sites\apfexample\pres\taglib
 * @class CurrentDateTag
 *
 * TagLib implementation to display the current date and time.<br />
 *
 * @author Christian Achatz
 * @version
 * Version 0.1, 20.04.2008<br />
 */
class CurrentDateTag extends Document {

   /**
    * @public
    *
    * Implements the Document's transform() method. Returns the current date and time.<br />
    *
    * @author Christian Achatz
    * @version
    * Version 0.1, 20.04.2008<br />
    */
   public function transform() {
      return date('l, d.m.Y, H:i:s');
   }

}
