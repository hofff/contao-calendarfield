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
 * Form fields
 */
$GLOBALS['TL_LANG']['FFL']['calendar'] = array('Kalenderfeld', 'ein Feld dass die von TYPOlight bekannte Kalender-Auswahl im Frontend anzeigt.');

/**
 * Errors
 */
$GLOBALS['TL_LANG']['ERR']['calendarfield_direction_ltToday'] = 'Bitte geben Sie ein Datum in der Vergangenheit (exkl. heute) ein.';
$GLOBALS['TL_LANG']['ERR']['calendarfield_direction_leToday'] = 'Bitte geben Sie ein Datum in der Vergangenheit (inkl. heute) ein.';
$GLOBALS['TL_LANG']['ERR']['calendarfield_direction_geToday'] = 'Bitte geben Sie ein Datum in der Zukunft (inkl. heute) ein.';
$GLOBALS['TL_LANG']['ERR']['calendarfield_direction_gtToday'] = 'Bitte geben Sie ein Datum in der Zukunft (exkl. heute) ein.';
