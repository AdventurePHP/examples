<?php
namespace SB\pres\validator;

use APF\tools\form\validator\TextFieldValidator;

class TemplateFileNameValidator extends TextFieldValidator {

   public function validate($input) {
      return preg_match('/^[A-Za-z0-9-_]+$/', $input);

   }

}
