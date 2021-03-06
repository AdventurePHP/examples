<?php
namespace EXAMPLE\calc\pres\controller;

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
use APF\core\pagecontroller\BaseDocumentController;
use APF\tools\form\taglib\SelectBoxTag;

/**
 * Implements the document controller to calculate the result of the module.
 *
 * @author Christian Achatz
 * @version
 * Version 0.1, 04.01.2011<br />
 */
class CalculatorController extends BaseDocumentController {

   public function transformContent() {

      $form = $this->getForm('Calc');

      if ($form->isSent() && $form->isValid()) {

         // read the input values as well as the operation to execute
         $operand1 = $form->getFormElementByName('operand1');
         $value1 = (float)$operand1->getAttribute('value');
         $operand2 = $form->getFormElementByName('operand2');
         $value2 = (float)$operand2->getAttribute('value');
         /* @var $operator SelectBoxTag */
         $operator = $form->getFormElementByName('operation');
         $currentOperator = $operator->getSelectedOption();
         $operatorType = $currentOperator->getAttribute('value');

         // execute operations
         if ($operatorType == 'plus') {
            $result = $value1 + $value2;
         } elseif ($operatorType == 'minus') {
            $result = $value1 - $value2;
         } elseif ($operatorType == 'div') {
            $result = $value1 / $value2;
         } else {
            $result = $value1 * $value2;
         }

         // inject result into the success tag
         $form->getFormElementByName('result')->setPlaceHolder('result', $result);
      }

      // always transform the form since it contains both error and success messages
      $form->transformOnPlace();
   }

}