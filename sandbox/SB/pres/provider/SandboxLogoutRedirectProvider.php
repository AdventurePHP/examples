<?php
namespace SB\pres\provider;

use APF\core\pagecontroller\APFObject;
use APF\modules\usermanagement\biz\login\UmgtRedirectUrlProvider;

class SandboxLogoutRedirectProvider extends APFObject implements UmgtRedirectUrlProvider {

   public function getRedirectUrl() {
      return '?page=login';
   }

}
