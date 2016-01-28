<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Hofff',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Forms
	'Hofff\Contao\Calendarfield\FormCalendarField' => 'system/modules/hofff_calendarfield/forms/FormCalendarField.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'form_calendarfield' => 'system/modules/hofff_calendarfield/templates/forms',
));
