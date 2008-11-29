<?php
   /**
   *  <!--
   *  This file is part of the adventure php framework (APF) published under
   *  http://adventure-php-framework.org.
   *
   *  The APF is free software: you can redistribute it and/or modify
   *  it under the terms of the GNU Lesser General Public License as published
   *  by the Free Software Foundation, either version 3 of the License, or
   *  (at your option) any later version.
   *
   *  The APF is distributed in the hope that it will be useful,
   *  but WITHOUT ANY WARRANTY; without even the implied warranty of
   *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   *  GNU Lesser General Public License for more details.
   *
   *  You should have received a copy of the GNU Lesser General Public License
   *  along with the APF. If not, see http://www.gnu.org/licenses/lgpl-3.0.txt.
   *  -->
   */

   /**
   *  @namespace core::cookie
   *  @class CookieManager
   *
   *  Stellt ein globales Session-Handling bereit.<br />
   *  <br />
   *  Verwendungsbeispiel:
   *     $oSessMgr = new sessionManager('<namespace>');
   *
   *  @author Christian Achatz
   *  @version
   *  Version 0.1, 08.03.2006<br />
   *  Version 0.2, 12.04.2006 (Möglichkeit hinzugefügt die Klasse singleton instanzieren zu können)<br />
   */
   class CookieManager
   {

      /**
      *  @private
      *  Namespace of the current instance.
      */
      var $__Namespace = 'default';


      /**
      *  @private
      *  Defines the default expiration time in seconds.
      */
      var $__ExpireTime = 86400; // one day


      /**
      *  @public
      *
      *  Konstruktor der Klasse.<br />
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 08.03.2006<br />
      */
      function CookieManager($namespace = null){

         if($namespace !== null){
            $this->setNamespace($namespace);
          // end if
         }

       // end function
      }


      /**
      *  @public
      *
      *  Sets the namespace of the current CookieManager instance.
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 08.11.2008<br />
      */
      function setNamespace($namespace){
         $this->__Namespace = str_replace('::','_',$namespace);
       // end function
      }


      /**
      *  @public
      *
      *  Creates a cookie within the current namespace
      *
      *  @param string $key desired cookie key
      *  @param string $value the value of the cookie
      *  @param int $expire the expiration time delta in seconds
      *  @param string $domain the domain, the cookie is valid for
      *  @return bool $success true, if cookie was set correctly, false, if something was wrong
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 08.11.2008<br />
      */
      function createCookie($key,$value,$expire = null,$domain = null){

         // set default expiration if not given as an argument
         if($expire === null){
            $expire = time() + $this->__ExpireTime;
          // end if
         }

         // set default domain (=current) if not given as an argument
         if($domain === null){
            $domain = $_SERVER['HTTP_HOST'];
          // end if
         }

         // call setcookie and return the result
         /*echo header('Set-Cookie: '.
                     $this->__Namespace.'['.$key.']'.
                     '='.
                     rawurlencode($value).
                     '; expires=Sun, 09 Nov 2008 22:38:10 GMT; path=/; domain=localhost'

         );*/

         return setcookie($key,$value,$expire,'/',$domain);

       // end function
      }


      /**
      *  @public
      *
      *  Returns the value of the desired key within the current namespace
      *
      *  @param string $key desired cookie key
      *  @return string $value cookie value or null
      *
      *  @author Christian Achatz
      *  @version
      *  Version 0.1, 08.11.2008<br />
      */
      function readCookie($key){

         /*if(isset($_COOKIE[$this->__Namespace][$key])){
            return $_COOKIE[$this->__Namespace][$key];
          // end if
         }*/
         if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
          // end if
         }
         else{
            return null;
          // end else
         }

       // end function
      }

      function updateCookie($key,$value,$expire = null){
      }

      function deleteCookie($key){
      }

      //setcookie(string $name,string $value,int $expire,string $path,string $domain);

    // end class
   }
?>