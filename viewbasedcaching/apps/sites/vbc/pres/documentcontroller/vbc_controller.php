<?php
   /**
   *  @namespace sites::vbc::pres::documentcontroller
   *  @class vbc_controller
   *
   *  Implements the document controller for the views 'view_one.html' and 'view_two.html'.
   *
   *  @author Christian Achatz
   *  @version
   *  Version 0.1, 29.11.2008<br />
   */
   class vbc_controller extends baseController
   {

      function vbc_controller(){
      }


      /**
      *  @public
      *
      *  Fills the timestamp place holder.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 29.11.2008<br />
      */
      function transformContent(){
         $this->setPlaceHolder('Timestamp',date('Y-m-d H:i:s'));
       // end function
      }

    // end function
   }
?>