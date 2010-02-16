<?php
   /**
   *  @namespace sites::apfexample::pres::taglib
   *
   *  Implements the taglib for highlighting a whole code file.
   *
   *  @author Christian Achatz
   *  @version
   *  Version 0.1, 19.04.2008<br />
   */
   class file_taglib_highlight extends Document
   {

      /**
      *  @private
      *  Stores the allowed files.
      */
      var $__Files = array();


      /**
      *  @public
      *
      *  Constructor of the class. Initializes the allowed files.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 19.04.2008<br />
      */
      function file_taglib_highlight(){

         $this->__Files = array(
                                'index.php' => 'index.php',
                                'website.html_de' => APPS__PATH.'/sites/apfexample/pres/templates/de/website.html'
                               );

       // end function
      }


      /**
      *  @public
      *
      *  Implements the transform() method of the class APFObject. Returns the HTML code of the tag.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 19.04.2008<br />
      */
      function transform(){

         // read name attribute
         if(!isset($this->__Attributes['name']) || empty($this->__Attributes['name'])){
            return (string)'<center><div class="phpsource" style="width: 795px; height: 30px;"><strong>Attribute "name" is not set or empty!</strong></div></center>';
          // end if
         }

         // check, if file is readable
         if(!isset($this->__Files[$this->__Attributes['name']])){
            return (string)'<center><div class="phpsource" style="width: 795px; height: 30px;"><strong>File "'.$this->__Attributes['name'].'" is not allowed to view!</strong></div></center>';
          // end if
         }

         // read file
         if(file_exists($this->__Files[$this->__Attributes['name']])){
            $SourceFileContent = file($this->__Files[$this->__Attributes['name']]);
          // end if
         }
         else{
            return (string)'<center><div class="phpsource" style="width: 795px; height: 30px;"><strong>File "'.$this->__Files[$this->__Attributes['name']].'" doesn\'t exist!</strong></div></center>';
          // end else
         }


         // calculate the div's hight
         // 16 px per line = 8px for letters + 8px distance
         $LineCount = count($SourceFileContent);
         $Height = ($LineCount * 8) + ($LineCount - 1) * 8;

         // define minimal height
         if($Height < 16){
            $Height = 28;
          // end if
         }

         // define maximum height
         if($Height > 500){
            $Height = 500;
          // end if
         }

         // concatinate the tag's content
         $Buffer = (string)'';
         $Buffer .= '<center>';
         $Buffer .= PHP_EOL;

         // don't limit height, if print perspective is displayed
         $Buffer .= '<div class="phpsource" style="width: 795px; height: '.$Height.'px;">';

         $Buffer .= PHP_EOL;
         $Buffer .= highlight_string(implode('',$SourceFileContent),true);
         $Buffer .= PHP_EOL;
         $Buffer .= '</div>';
         $Buffer .= PHP_EOL;
         $Buffer .= '</center>';

         // return the tag's content
         return $Buffer;

       // end function
      }

    // end class
   }
?>