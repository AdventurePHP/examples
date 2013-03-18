<?php
namespace APF\sandbox\pres\provider;

use APF\modules\usermanagement\biz\login\UmgtRedirectUrlProvider;

class SandboxLogoutRedirectProvider extends APFObject implements UmgtRedirectUrlProvider {

   public function getRedirectUrl() {
      return '?page=login';
   }

}
