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
$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']          = array('Datumsformat', 'Der Datumsformat-String wird mit der PHP-Funktion date() geparst.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']       = array('Datumsrichtung', 'Wählen Sie ob die Datumsauswahl eingeschränkt werden soll.');
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']      = array('Standard-Wert konvertieren', 'Den Standard-Wert mittels PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">strtotime()</a> analysieren.');
$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSS']      = array('CSS-Datei einbinden', 'Aktivieren Sie diese Option wenn Sie die jQuery UI CSS-Datei für das Popup einbinden wollen.');
$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSSTheme'] = array('jQuery UI Theme', 'Wählen Sie das zu verwendende jQuery UI Theme aus. Weiter Informationen dazu gibt es auf der jQuery UI Webseite: <a hre="http://jqueryui.com/themeroller">http://jqueryui.com/themeroller</a>');
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']           = array('Kalender-Icon anzeigen', 'Klicken Sie hier um das Kalender-Icons anzuzeigen.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']        = array('Eigenes Icons', 'Wählen Sie ein Icons, welches anstelle dem Standardbild verwendet werden soll.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['all']     = 'Alle Daten erlaubt';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['ltToday'] = 'Nur Datum in der Vergangenheit (exkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['leToday'] = 'Nur Datum in der Vergangenheit (inkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['geToday'] = 'Nur Datum in der Zukunft (inkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['gtToday'] = 'Nur Datum in der Zukunft (exkl. Heute)';
