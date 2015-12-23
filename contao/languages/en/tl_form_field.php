<?php

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
$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']          = array('Date format', 'The date format string will be parsed with the PHP date() function.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']       = array('Date direction', 'Select if date selection is restricted.');
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']      = array('Parse default value', 'Parse default value using PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">strtotime()</a>.');
$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSS']      = array('Include CSS file', 'Check here if you want to include the jQuery UI CSS files to style the popup.');
$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSSTheme'] = array('jQuery UI theme', 'Please select the jQuery UI theme. For further information please have a look at the jQuery UI webseite: <a hre="http://jqueryui.com/themeroller">http://jqueryui.com/themeroller</a>');
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']           = array('Show calendar icon', 'Click here to show a calendar picker icon.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']        = array('Custom icon', 'Select a custom image to replace the default calendar icon.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['all']     = 'Allow all dates';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['ltToday'] = 'Only dates in the past (excluding today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['leToday'] = 'Only dates in the past (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['geToday'] = 'Only dates in the future (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['gtToday'] = 'Only dates in the future (excluding today)';
