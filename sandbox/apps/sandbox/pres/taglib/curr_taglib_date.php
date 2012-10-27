<?php
/**
 * @package sites::apfexample::pres::taglib
 * @class curr_taglib_date
 *
 * TagLib implementation to display the current date and time.<br />
 *
 * @author Christian Achatz
 * @version
 * Version 0.1, 20.04.2008<br />
 */
class curr_taglib_date extends Document {

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
