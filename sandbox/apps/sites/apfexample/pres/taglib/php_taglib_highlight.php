<?php
   /**
   *  @namespace sites::apfexample::pres::taglib
   *  @class php_taglib_highlight
   *
   *  Implements the php source code highlighting taglib.
   *
   *  @author Christian Achatz
   *  @version
   *  Version 0.1, 08.04.2007<br />
   */
   class php_taglib_highlight extends Document
   {

      function php_taglib_highlight(){
      }


      /**
      *  @public
      *
      *  Implements the transform() methode of the class APFObject. Returns the HTML code of the tag.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 08.04.2007<br />
      *  Version 0.2, 05.05.2007 (PHP tags are not displayed any more)<br />
      *  Version 0.3, 01.07.2007 (Fixed display bug. CSS class "div.phpcode" is now used to format the source code)<br />
      *  Version 0.4, 21.08.2007 (Added PHP 5 support, because highlight_string() is little bit different)<br />
      *  Version 0.5, 16.09.2007 (Improved PHP 5 support)<br />
      *  Version 0.6, 02.01.2008 (Limited code box to maximum hight of 400px)<br />
      */
      function transform(){

         // Gather line count
         $LineCount = substr_count($this->__Content,"\n") - 1;

         // Highlight source code
         // - Remove line breaks
         // - Remove line breaks and blanks at the end of the code
         // - Remove line breaks and blanks around the whole source code
         $HighlightedContent = highlight_string(trim('<?php '.ltrim(rtrim($this->__Content),"\x0A..\x0D").' ?>'),true);

         // replace PHP start and end tag
         $HighlightedContent = str_replace('<font color="#007700">&lt;?</font>','',$HighlightedContent);
         $HighlightedContent = str_replace('<font color="#0000BB">&lt;?php&nbsp;','<font color="#0000BB">',$HighlightedContent);
         $HighlightedContent = str_replace('<font color="#0000BB">php','<font color="#0000BB">',$HighlightedContent);
         $HighlightedContent = str_replace('<font color="#0000BB">&nbsp;</font>','',$HighlightedContent);

         // Additionsal code for PHP 5 support
         $HighlightedContent = str_replace('<span style="color: #0000BB">&lt;?php&nbsp;','<span style="color: #0000BB">',$HighlightedContent);
         $HighlightedContent = str_replace('<span style="color: #0000BB">&lt;?php','<span style="color: #0000BB">',$HighlightedContent);
         $HighlightedContent = str_replace('<span style="color: #0000BB">?&gt;</span>','',$HighlightedContent);

         // Replace PHP end tag
         $HighlightedContent = str_replace('<font color="#0000BB">?&gt;</font>','',$HighlightedContent);

         // Add a hight limit if necessary
         if($LineCount > 27){
            return '<div class="phpcode" style="height: 400px; overflow: auto;">'.$HighlightedContent.'</div>';
          // end if
         }
         else{
            return '<div class="phpcode">'.$HighlightedContent.'</div>';
          // end else
         }

       // end function
      }

    // end class
   }
?>