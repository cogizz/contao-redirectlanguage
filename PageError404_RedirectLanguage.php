<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Christopher Bölter 2013
 * @author     Christopher Bölter <http://www.cogizz.de>
 * @package    RedirectLanguage
 * @license    LGPL
 * @filesource
 */


/**
 * Class PageError404_RedirectLanguage
 *
 * Provide methods to handle a language redirect based on https://github.com/contao/core/issues/4669
 * @copyright  Christopher Bölter 2013
 * @author     Christopher Bölter <http://www.cogizz.de>
 * @package    RedirectLanguage
 */
class PageError404_RedirectLanguage extends PageError404
{


	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->redirectLanguage();
	}

	/**
	 * add the language param to the url if there is none
	 */
	protected function redirectLanguage()
	{
		// Find the matching root page
		$objRootPage = $this->getRootPageFromUrl();

		// Forward if the language should be but is not set (see #4028)
		if ($GLOBALS['TL_CONFIG']['addLanguageToUrl']) {
			// Get the request string without the index.php fragment
			if ($this->Environment->request == 'index.php') {
				$strRequest = '';
			} else {
				$strRequest = str_replace('index.php/', '', $this->Environment->request);
			}

			// Only redirect if there is no language fragment (see #4669)
			if ($strRequest != '' && !preg_match('@^[a-z]{2}/@', $strRequest)) {
				$this->redirect(($GLOBALS['TL_CONFIG']['rewriteURL'] ? '' : 'index.php/') . $objRootPage->language . '/' . $strRequest, 301);
			}
		}
	}
}