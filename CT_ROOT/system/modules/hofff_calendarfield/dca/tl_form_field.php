<?php

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__']  = array_merge($GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'], array('dateImage', 'dateIncludeCSS'));
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['calendarfield'] = '{type_legend},type,name,label;{fconfig_legend},mandatory,placeholder,dateFormat,dateDirection,dateIncludeCSS,dateImage,dateDisabledWeekdays,dateDisabledDays;{expert_legend:hide},value,dateParseValue,class,accesskey,tabindex;{template_legend:hide},customTpl;{submit_legend},addSubmit';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['dateIncludeCSS'] = 'dateIncludeCSSTheme';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['dateImage']      = 'dateImageSRC';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateFormat'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateFormat'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('helpwizard'=>true, 'tl_class'=>'clr w50'),
	'explanation'             => 'dateFormat',
	'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateDirection'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirection'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('all', 'ltToday', 'leToday', 'geToday', 'gtToday'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref'],
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateParseValue'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateIncludeCSS'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSS'],
	'exclude'                 => true,
	'default'                 => '1',
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateIncludeCSSTheme'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateIncludeCSSTheme'],
	'exclude'                 => true,
	'default'                 => 'smoothness',
	'inputType'               => 'select',
	'options'                 => array("black-tie", "blitzer", "cupertino", "dark-hive", "dot-luv", "eggplant", "excite-bike", "flick", "hot-sneaks", "humanity", "le-frog", "mint-choc", "overcast", "pepper-grinder", "redmond", "smoothness", "south-street", "start", "sunny", "swanky-purse", "trontastic", "ui-darkness", "ui-lightness", "vader"),
	'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true),
	'sql'                     => "varchar(64) NOT NULL default 'smoothness'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateImage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateImage'],
	'exclude'                 => true,
	'default'                 => '1',
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr'),
	'sql'                     => "char(1) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateImageSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('files'=>true,'fieldType'=>'radio','filesOnly'=>true,'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateDisabledWeekdays'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledWeekdays'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array("1", "2", "3", "4", "5", "6", "0"),
	'reference'               => &$GLOBALS['TL_LANG']['DAYS'],  
	'eval'                    => array('tl_class'=>'w50 clr', 'multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateDisabledDays'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDays'],
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array
	(
		'style'        => 'min-width: 100%;',
		'tl_class'     =>'clr',
    'minCount'        => 0,

		'columnFields' => array
		(
			'date' => array
			(
				'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysDate'],
				'exclude'          => true,
				'inputType'        => 'text',
				'eval'             => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'wizard'),
			),
			'active' => array
			(
				'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysActive'],
				'exclude'          => true,
				'inputType'        => 'checkbox'
			)
		)
	),
	'sql'            => "blob NOT NULL"
); 

