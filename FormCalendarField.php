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
 * @copyright  Andreas Schempp 2009-2011
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */


class FormCalendarField extends FormTextField
{


	public function __construct($arrAttributes=false)
	{
		parent::__construct($arrAttributes);
		
		if ($this->rgxp != 'datim' && $this->rgxp != 'time')
			$this->rgxp = 'date';
	}
	
	
	public function generate()
	{
		$dateFormat = strlen($this->dateFormat) ? $this->dateFormat : $GLOBALS['TL_CONFIG'][$this->rgxp . 'Format'];
		$dateDirection = strlen($this->dateDirection) ? $this->dateDirection : '0';
		$jsEvent = $this->jsevent ? $this->jsevent : 'domready';
		
		if ($this->dateParseValue && $this->varValue != '')
		{
			$this->varValue = $this->parseDate($dateFormat, strtotime($this->varValue));
		}
		
		$strBuffer = parent::generate();
		
		if ($this->readonly || $this->disabled)
			return $strBuffer;
		
		if (version_compare(VERSION, '2.10', '<'))
		{
			return $this->generateWithCalendar($strBuffer, $dateFormat, $dateDirection, $jsEvent);
		}
		else
		{
			return $this->generateWithDatepicker($strBuffer, $dateFormat, $dateDirection, $jsEvent);
		}
	}
	
	
	/**
	 * Generate for datepicker script since Contao 2.10
	 */
	protected function generateWithDatepicker($strBuffer, $dateFormat, $dateDirection, $jsEvent)
	{
		$GLOBALS['TL_CSS'][] = 'plugins/datepicker/dashboard.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/datepicker/datepicker.js';

		switch ($this->rgxp)
		{
			case 'datim':
				$time = ",\n      timePicker:true";
				break;

			case 'time':
				$time = ",\n      timePickerOnly:true";
				break;

			default:
				$time = '';
				break;
		}
		
		switch( $dateDirection )
		{
			case '+1':
				$dateDirection = ",\n	minDate: {date:'" . $this->parseDate($dateFormat, strtotime('+1 day')) . "', format: '" . $dateFormat . "'}";
				break;

			case '-1':
				$dateDirection = ",\n	maxDate: {date:'" . $this->parseDate($dateFormat, strtotime('-1 day')) . "', format: '" . $dateFormat . "'}";
				break;

			default:
				$dateDirection = '';
				break;
		}

		$strBuffer .= ' <img src="plugins/datepicker/icon.gif" width="20" height="20" alt="" id="toggle_' . $this->strId . '" style="vertical-align:-6px;">
  <script>
  window.addEvent(\'' . $jsEvent . '\', function() {
    new DatePicker(\'#ctrl_' . $this->strId . '\', {
      allowEmpty:true,
      toggleElements:\'#toggle_' . $this->strId . '\',
      pickerClass:\'datepicker_dashboard\',
      format:\'' . $dateFormat . '\',
      inputOutputFormat:\'' . $dateFormat . '\',
      positionOffset:{x:130,y:-185}' . $time . ',
      startDay:' . $GLOBALS['TL_LANG']['MSC']['weekOffset'] . ',
      days:[\''. implode("','", $GLOBALS['TL_LANG']['DAYS']) . '\'],
      dayShort:' . $GLOBALS['TL_LANG']['MSC']['dayShortLength'] . ',
      months:[\''. implode("','", $GLOBALS['TL_LANG']['MONTHS']) . '\'],
      monthShort:' . $GLOBALS['TL_LANG']['MSC']['monthShortLength'] . $dateDirection . '
    });
  });
  </script>';
		
		return $strBuffer;
	}
	
	
	/**
	 * Generate for calendar script prior to Contao 2.10
	 */
	protected function generateWithCalendar($strBuffer, $dateFormat, $dateDirection, $jsEvent)
	{
		$GLOBALS['TL_CSS'][] = 'plugins/calendar/css/calendar.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/calendar/js/calendar.js';
		
		$strBuffer .= "<script type=\"text/javascript\">" . ($jsEvent == 'domready' ? '<!--//--><![CDATA[//><!--' : '') . "
  window.addEvent('" . $jsEvent . "', function() { new Calendar({ ctrl_" . $this->strId . ": '" . $dateFormat . "' }, { navigation: 2, days: ['" . implode("','", $GLOBALS['TL_LANG']['DAYS']) . "'], months: ['" . implode("','", $GLOBALS['TL_LANG']['MONTHS']) . "'], offset: ". intval($GLOBALS['TL_LANG']['MSC']['weekOffset']) . ", titleFormat: '" . $GLOBALS['TL_LANG']['MSC']['titleFormat'] . "', direction: " . $dateDirection . " }); });
  " . ($jsEvent == 'domready' ? '//--><!]]>' : '') . "</script>";
  
  		return $strBuffer;
	}
	
	
	public function validator($varInput)
	{
		if (strlen($this->dateFormat))
		{
			// Disable regular date validation
			$this->rgxp = '';
			
			if (strlen($varInput) && !preg_match('/'. $this->getRegexp($this->dateFormat) .'/i', $varInput))
			{
				$objDate = new Date();
				$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['date'], $objDate->getInputFormat($this->dateFormat)));
			}
		}
		
		return parent::validator($varInput);
	}
	
	
	/**
	 * Return a regular expression that matches a particular date format
	 * @param  string
	 * @param  string
	 * @return string
	 */
	private function getRegexp($strFormat=false, $strRegexpSyntax='perl')
	{
		if (!$strFormat)
		{
			$strFormat = $GLOBALS['TL_CONFIG']['dateFormat'];
		}

		if (preg_match('/[BbCcDEeFfIJKkLlMNOoPpQqRrSTtUuVvWwXxZz]+/', $strFormat))
		{
			throw new Exception(sprintf('Invalid date format "%s"', $strFormat));
		}

		$arrRegexp = array();
		$arrCharacters = str_split($strFormat);

		foreach ($arrCharacters as $strCharacter)
		{
			switch ($strCharacter)
			{
				// Patch day: allow 01 - 31
				case 'd':
					$arrRegexp[$strFormat]['perl']  .= '(0[1-9]|[12][0-9]|3[01])';
					$arrRegexp[$strFormat]['posix'] .= '(0[1-9]|[12][0-9]|3[01])';
					break;
				
				// Patch month: allow 01 - 12
				case 'm':
					$arrRegexp[$strFormat]['perl']  .= '(0[1-9]|1[012])';
					$arrRegexp[$strFormat]['posix'] .= '(0[1-9]|1[012])';
					break;
				
				// Patch year: allow 1900 - 2099
				case 'Y':
					$arrRegexp[$strFormat]['perl']  .= '(19|20)[0-9]{2,2}';
					$arrRegexp[$strFormat]['posix'] .= '(19|20)[[:digit:]]{2}';
					break;
					
				case 'a':
				case 'A':
					$arrRegexp[$strFormat]['perl']  .= '[apmAPM]{2,2}';
					$arrRegexp[$strFormat]['posix'] .= '[apmAPM]{2}';
					break;

				case 'y':
				case 'h':
				case 'H':
				case 'i':
				case 's':
					$arrRegexp[$strFormat]['perl']  .= '[0-9]{2,2}';
					$arrRegexp[$strFormat]['posix'] .= '[[:digit:]]{2}';
					break;

				case 'j':
				case 'n':
				case 'g':
				case 'G':
					$arrRegexp[$strFormat]['perl']  .= '[0-9]{1,2}';
					$arrRegexp[$strFormat]['posix'] .= '[[:digit:]]{1,2}';
					break;

				default:
					$arrRegexp[$strFormat]['perl']  .= preg_quote($strCharacter, '/');
					$arrRegexp[$strFormat]['posix'] .= preg_quote($strCharacter, '/');
					break;
			}
		}

		return $arrRegexp[$strFormat][$strRegexpSyntax];
	}
}

