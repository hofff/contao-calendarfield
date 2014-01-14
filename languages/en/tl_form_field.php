<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 * @copyright  Andreas Schempp 2009-2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']  		= array('Date format', 'The date format string will be parsed with the PHP date() function.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']		= array('Date direction', 'Select if date selection is restricted.');
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']		= array('Parse default value', 'Parse default value using PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">strtotime()</a>.');
$GLOBALS['TL_LANG']['tl_form_field']['dateExcludeCSS']		= array('Do not include CSS', 'Check here if you want to include your own CSS styles for the popup.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']			= array('Show calendar icon', 'Click here to show a calendar picker icon.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']		= array('Custom icon', 'Select a custom image to replace the default calendar icon.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageOnly']		= array('Force date picker', 'Check here if the date must not be entered manually.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['0']	= 'Allow all dates';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['+1']	= 'Only dates in the future (excluding today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['+0']	= 'Only dates in the future (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['-1']	= 'Only dates in the past';

