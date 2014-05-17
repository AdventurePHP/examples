<?php
namespace EXAMPLE\calc\pres\validator;

/**
 * <!--
 * This file is part of the adventure php framework (APF) published under
 * http://adventure-php-framework.org.
 *
 * The APF is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The APF is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with the APF. If not, see http://www.gnu.org/licenses/lgpl-3.0.txt.
 * -->
 */
use APF\tools\form\taglib\HtmlFormTag;
use APF\tools\form\taglib\SelectBoxTag;
use APF\tools\form\validator\TextFieldValidator;

/**
 * @package APF\examples\pres\validator
 * @class ZeroDivisionValidator
 *
 * Implements a validator that checks for division by zero.
 *
 * @author Christian Achatz
 * @version
 * Version 0.1, 04.01.2011<br />
 * Version 0.2, 07.09.2013 (Migration to APF 2.0)<br />
 */
class ZeroDivisionValidator extends TextFieldValidator {

   public function validate($input) {

      /* @var $form HtmlFormTag */
      $form = & $this->control->getParentObject();

      /* @var $operation SelectBoxTag */
      $operation = $form->getFormElementByName('operation');
      $operation = $operation
            ->getSelectedOption()
            ->getAttribute('value');

      if ($operation === 'div' && is_numeric($input) && (float) $input === 0.0) {
         return false;
      }
      return true;
   }

}