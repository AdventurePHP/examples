<?php
import('modules::usermanagement::biz::login', 'UmgtRedirectUrlProvider');

class SandboxLoginRedirectProvider extends APFObject implements UmgtRedirectUrlProvider {

   public function getRedirectUrl() {
      return '?page=login';
   }

}
