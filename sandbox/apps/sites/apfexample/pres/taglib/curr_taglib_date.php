<?php
   /**
   *  @namespace sites::apfexample::pres::taglib
   *
   *  TagLib implementation to display the current date and time.<br />
   *
   *  @author Christian Achatz
   *  @version
   *  Version 0.1, 20.04.2008<br />
   */
   class curr_taglib_date extends Document
   {

      function curr_taglib_date(){
      }


      /**
      *  @public
      *
      *  Implements the Document's transform() method. Returns the current date and time.<br />
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 20.04.2008<br />
      */
      function transform(){
         return date('l, d.m.Y, H:i:s');
       // end function
      }

    // end class
   }
?>