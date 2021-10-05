<?php

/**
 * Form fields
 */
$GLOBALS['TL_LANG']['FFL']['calendarfield'] = array('Calendar field', 'Form field for providing a date selection in frontend.');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']              = array('Date format', 'The date format string will be parsed with the PHP date() function.');
$GLOBALS['TL_LANG']['tl_form_field']['dateCssTheme']            = array('Theme', 'Please select the theme.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']           = array('Date direction', 'Please select if date selection is restricted.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionMinMax']     = array('Min. / max. values for date', 'Please enter your own min. and max. values for the date. Enter the days as integer values, which are valid starting from the current day. With negative values the calculation is backwards.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']               = array('Show calendar icon', 'Please select if a calendar picker icon should be used.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']            = array('Custom icon', 'Select a custom image to replace the default calendar icon.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSize']           = array('Image size', 'Set the image dimensions and the resize mode.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledWeekdays']    = array('Disallowed weekdays', 'Select the weekdays that are not allowed and therefore should not be selectable.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDays']        = array('Disallowed days', 'Select the dates of days that are not allowed and therefore should not be selectable.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysDate']    = array('Date', 'Select the date of the day that is not allowed and therefore should not be selectable.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysActive']  = array('Active', 'Select whether this definition is currently active and is to be used or not.');
$GLOBALS['TL_LANG']['tl_form_field']['dateCustomConfiguration'] = array('Custom configuration', 'Please enter custom configuration of the flatpickr.js widget. This has to be valid <i>JSON</i>. The here entered configuration will be appended at the end. This will overwrite already existing configuration options from above. For more information of the configuration option have a look in the documentation at <a href="https://flatpickr.js.org/options/">https://flatpickr.js.org</a>.');
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']          = array('Parse default value', 'Parse default value using PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">strtotime()</a>.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['all']       = 'Allow all dates';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['ltToday']   = 'Only dates in the past (excluding today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['leToday']   = 'Only dates in the past (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['geToday']   = 'Only dates in the future (including today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['gtToday']   = 'Only dates in the future (excluding today)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['ownMinMax'] = 'Define own min and max values';
