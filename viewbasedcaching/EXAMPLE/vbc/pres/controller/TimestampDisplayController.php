<?php
namespace EXAMPLE\vbc\pres\controller;

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

/**
 * @package EXAMPLE\vbc\pres\controller
 * @class TimestampDisplayController
 *
 * Implements the document controller for the views 'one.html' and 'two.html'.
 *
 * @author Christian Achatz
 * @version
 * Version 0.1, 29.11.2008<br />
 */
class TimestampDisplayController extends BaseDocumentController {

   public function transformContent() {
      $this->setPlaceHolder('Timestamp', date('Y-m-d H:i:s'));
   }

}
