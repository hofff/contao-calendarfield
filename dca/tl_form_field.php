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
 * Config
 */
$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = array('tl_form_field_calendarfield', 'adjustFields');


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'dateImage';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['calendar'] = '{type_legend},type,name,label;{fconfig_legend},rgxp,mandatory,placeholder,maxlength,dateFormat,dateDirection,dateExcludeCSS,dateImage;{expert_legend:hide},value,dateParseValue,class,accesskey;{submit_legend},addSubmit';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['dateImage'] = 'dateImageSRC,dateImageOnly';


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
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateDirection'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirection'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'				  => array('0', '-1', '+0', '+1'),
	'reference'				  => &$GLOBALS['TL_LANG']['tl_form_field']['dateDirection_ref'],
	'eval'                    => array('tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateParseValue'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateExcludeCSS'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateExcludeCSS'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateImage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateImage'],
	'exclude'                 => true,
	'default'				  => '1',
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateImageSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('files'=>true,'fieldType'=>'radio','filesOnly'=>true,'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dateImageOnly'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dateImageOnly'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50'),
);


class tl_form_field_calendarfield extends Backend
{

	public function adjustFields($dc)
	{
		if ($this->Input->get('act') == 'edit')
		{
			$objField = $this->Database->execute("SELECT * FROM tl_form_field WHERE id=".$dc->id);

			if ($objField->type == 'calendar')
			{
				$GLOBALS['TL_DCA']['tl_form_field']['fields']['mandatory']['eval']['tl_class'] = 'w50 m12';
				$GLOBALS['TL_DCA']['tl_form_field']['fields']['value']['eval']['tl_class'] = 'w50';
			}
		}
	}
}

