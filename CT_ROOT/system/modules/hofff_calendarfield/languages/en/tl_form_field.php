<?php

/**
 * Form fields
 */
$GLOBALS['TL_LANG']['FFL']['calendarfield'] = array('Calendar field (jQuery)', 'Form field for providing a calendar selection in frontend (jQuery version).');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']             = array('Date format', 'The date format string will be parsed with the PHP date() function.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']          = array('Date direction', 'Select if date selection is restricted.');
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']         = array('Parse default value', 'Parse default value using PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">strtotime()</a>.');
$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSS']         = array('Include CSS file', 'Check here if you want to include the jQuery UI CSS files to style the popup.');
$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSSTheme']    = array('jQuery UI theme', 'Please select the jQuery UI theme. For further information please have a look at the jQuery UI webseite <a hre="http://jqueryui.com/themeroller">http://jqueryui.com/themeroller</a>. For the integration a working internet connection is required.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']              = array('Show calendar icon', 'Click here to show a calendar picker icon.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']           = array('Custom icon', 'Select a custom image to replace the default calendar icon.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledWeekdays']   = array('Disallowed weekdays', 'Select the weekdays that are not allowed and therefore should not be selectable.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDays']       = array('Disallowed days', 'Select the dates of days that are not allowed and therefore should not be selectable.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysDate']   = array('Date', 'Select the date of the day that is not allowed and therefore should not be selectable.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysActive'] = array('Active', 'Select whether this definition is currently active and is to be used or not.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['all']     = 'Allow all dates';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['ltToday'] = 'Only dates in the past (excluding today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['leToday'] = 'Only dates in the past (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['geToday'] = 'Only dates in the future (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref']['gtToday'] = 'Only dates in the future (excluding today)';
