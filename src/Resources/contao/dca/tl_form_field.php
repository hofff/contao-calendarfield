<?php

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__']  = array_merge($GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'], array('dateDirection', 'dateImage'));
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['calendarfield'] = '{type_legend},type,name,label;{fconfig_legend},mandatory,placeholder,dateFormat,dateCssTheme,dateDirection,dateImage,dateDisabledWeekdays,dateDisabledDays,dateCustomConfiguration;{expert_legend:hide},class,value,dateParseValue,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['dateDirection_ownMinMax'] = 'dateDirectionMinMax';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['dateImage']               = 'dateImageSRC,dateImageSize';

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

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateCssTheme'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateCssTheme'],
  'exclude'                 => true,
  'default'                 => '',
  'inputType'               => 'select',
  'options'                 => array("airbnb", "confetti", "dark", "light", "material_blue", "material_green", "material_orange", "material_red"),
  'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true),
  'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateDirection'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirection'],
  'exclude'                 => true,
  'inputType'               => 'select',
  'options'                 => array('all', 'ltToday', 'leToday', 'geToday', 'gtToday', 'ownMinMax'),
  'reference'               => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions'],
  'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50'),
  'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateDirectionMinMax'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionMinMax'],
  'exclude'                 => true,
  'inputType'               => 'text',
  'eval'                    => array('rgxp'=>'digit', 'multiple'=>true, 'size'=>2, 'tl_class'=>'clr w50'),
  'sql'                     => "varchar(255) NOT NULL default ''"
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

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateImageSize'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateImageSize'],
  'exclude'                 => true,
  'inputType'               => 'imageSize',
  'reference'               => &$GLOBALS['TL_LANG']['MSC'],
  'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
  'options_callback' => static function ()
  {
    return Contao\System::getContainer()->get('contao.image.sizes')->getOptionsForUser(Contao\BackendUser::getInstance());
  },
  'sql'                     => "varchar(255) NOT NULL default ''"
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
        'eval'             => array('rgxp'=>'date', 'datepicker'=>true, 'tl_class'=>'wizard', 'style'=>'width: 300px;'),
      ),
      'active' => array
      (
        'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysActive'],
        'exclude'          => true,
        'inputType'        => 'checkbox'
      )
    )
  ),
  'sql'            => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateCustomConfiguration'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateCustomConfiguration'],
  'exclude'                 => true,
  'inputType'               => 'textarea',
  'eval'                    => array('decodeEntities' => true, 'allowHtml' => false, 'class'=>'monospace', 'rte'=>'ace|yaml'),
  'sql'                     => "text NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateParseValue'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue'],
  'exclude'                 => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50 m12'),
  'sql'                     => "char(1) NOT NULL default ''"
);
