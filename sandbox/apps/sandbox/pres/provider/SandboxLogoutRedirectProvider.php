<?php
import('modules::usermanagement::biz::login', 'UmgtRedirectUrlProvider');

class SandboxLogoutRedirectProvider extends APFObject implements UmgtRedirectUrlProvider {

   public function getRedirectUrl() {
      return '?page=login';
   }

}
