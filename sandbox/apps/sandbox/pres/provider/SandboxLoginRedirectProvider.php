<?php

import('modules::usermanagement::biz::login', 'LoginRedirectUrlProvider');

class SandboxLoginRedirectProvider extends APFObject implements LoginRedirectUrlProvider {

   public function getRedirectUrl() {
      return '?page=login';
   }

}

?>