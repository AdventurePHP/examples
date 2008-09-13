<?php
   import('modules::guestbook::biz','guestbookManager');
   import('core::session','sessionManager');
   import('modules::guestbook::pres::documentcontroller','guestbookBaseController');


   /**
   *  @package modules::guestbook::pres::documentcontroller
   *  @class guestbook_admindelete_v1_controller
   *
   *  Implementiert den DocumentController f�r das Stylesheet 'admindelete.html'.<br />
   *
   *  @author Christian Sch�fer
   *  @version
   *  Version 0.1, 05.05.2007<br />
   */
   class guestbook_admindelete_v1_controller extends guestbookBaseController
   {

      /**
      *  @private
      *  H�lt lokal verwendete Variablen.
      */
      var $_LOCALS;


      function guestbook_admindelete_v1_controller(){
         $this->_LOCALS = variablenHandler::registerLocal(array('entryid'));
       // end function
      }


      /**
      *  @public
      *
      *  Implementiert die abstrakte Methode aus coreObject.<br />
      *
      *  @author Christian Sch�fer
      *  @version
      *  Version 0.1, 05.05.2007<br />
      */
      function transformContent(){

         // Referenz auf die Formulare holen
         $Form__FormNo = &$this->__getForm('FormNo');
         $Form__FormYes = &$this->__getForm('FormYes');

         // SessionManager erzeugen
         $oSessMgr = new sessionManager('Module_Guestbook');

         if($oSessMgr->loadSessionData('AdminView') == true){

            // Aktion ausf�hren f�r abgesendetes NEIN-Formular
            if($Form__FormNo->get('isSent')){
               $Link = linkHandler::generateLink($_SERVER['REQUEST_URI'],array('gbview' => 'display','entryid' => ''));
               header('Location: '.$Link);
             // end if
            }

            // Aktion ausf�hren f�r abgesendetes JA-Formular
            if($Form__FormYes->get('isSent')){

               // Manager holen
               $gM = &$this->__getGuestbookManager();

               // Entry erzeugen
               $Entry = new Entry();
               $Entry->set('ID',$this->_LOCALS['entryid']);

               // Eintrag l�schen
               $gM->deleteEntry($Entry);

               // Auf Anzeige-Seite weiterleiten
               $Link = linkHandler::generateLink($_SERVER['REQUEST_URI'],array('gbview' => 'display','entryid' => ''));
               header('Location: '.$Link);

             // end if
            }

            // Formular anzeigen
            $this->setPlaceHolder('FormNo',$Form__FormNo->transformForm());
            $this->setPlaceHolder('FormYes',$Form__FormYes->transformForm());

          // end if
         }
         else{
            $Link = linkHandler::generateLink($_SERVER['REQUEST_URI'],array('gbview' => 'display','entryid' => ''));
            header('Location: '.$Link);
          // end else
         }

       // end function
      }

    // end class
   }
?>