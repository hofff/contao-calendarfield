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


class FormCalendarField extends FormTextField
{


	public function __construct($arrAttributes=false)
	{
		parent::__construct($arrAttributes);
		
		if ($this->rgxp != 'datim' && $this->rgxp != 'time')
		{
			$this->rgxp = 'date';
		}
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
		{
			return $strBuffer;
		}
		
		return $this->generateWithDatepicker($strBuffer, $dateFormat, $dateDirection, $jsEvent);
	}
	
	
	/**
	 * Generate for datepicker script since Contao 2.10
	 */
	protected function generateWithDatepicker($strBuffer, $dateFormat, $dateDirection, $jsEvent)
	{
		$GLOBALS['TL_CSS'][] = 'plugins/datepicker/dashboard.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'plugins/datepicker/datepicker.js';
		
		// in the back end this is inlcuded automatically
		if (TL_MODE == 'FE')
		{
			$GLOBALS['TL_HEAD'][] = $this->getDateString();
		}

		switch ($this->rgxp)
		{
			case 'datim':
				$rgxp = ",\n      timePicker:true";
				break;

			case 'time':
				$rgxp = ",\n      pickOnly:\"time\"";
				break;

			default:
				$rgxp = '';
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
		
		// icon
		$strIcon = ($this->icon) ? $this->icon : 'plugins/datepicker/icon.gif';
		$arrSize = @getimagesize(TL_ROOT . '/' . $strIcon);
		
		// seems to be necessary for the backend but does only hurt in the FE
		$style = (TL_MODE == 'BE') ? ' style="vertical-align:-6px;"' : '';
		
		// correctly style the date format
		$dateFormat = Date::formatToJs($dateFormat);
		
		// make offsets configurable (useful for the front end but can be used in the back end as well)
		$intOffsetX = (is_numeric($this->offsetX)) ? $this->offsetX : -197;
		$intOffsetY = (is_numeric($this->offsetY)) ? $this->offsetY : -182;

		$strBuffer .= ' <img src="' . $strIcon . '" width="' . $arrSize[0] . '" height="' . $arrSize[1] . '" class="datepicker" alt="" id="toggle_' . $this->strId . '"' . $style . '>
' . $this->getScriptTag() . "
window.addEvent('" . $jsEvent . "', function() {
  new Picker.Date($$('#ctrl_" . $this->strId . "'), {
    draggable:" . (($this->draggable) ? 'true' : 'false' ) . ",
    toggle:$$('#toggle_" . $this->strId . "'),
    format:'" . $dateFormat . "',
    positionOffset:{x:" . $intOffsetX . ",y:" . $intOffsetY . "}" . $rgxp . ",
    pickerClass:'datepicker_dashboard',
    useFadeInOut:!Browser.ie,
    startDay:" . $GLOBALS['TL_LANG']['MSC']['weekOffset'] . ",
    titleFormat:'" . $GLOBALS['TL_LANG']['MSC']['titleFormat'] . "'
  });
});
</script>";
  
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


	/**
	 * Return the datepicker string
	 * 
	 * Fix the MooTools more parsers which incorrectly parse ISO-8601 and do
	 * not handle German date formats at all.
	 * @return string
	 */
	protected function getDateString()
	{
		return $this->getScriptTag() . '
window.addEvent("domready",function(){
  Locale.define("en-US","Date",{
    months:["' . implode('","', $GLOBALS['TL_LANG']['MONTHS']) . '"],
    days:["' . implode('","', $GLOBALS['TL_LANG']['DAYS']) . '"],
    months_abbr:["' . implode('","', $GLOBALS['TL_LANG']['MONTHS_SHORT']) . '"],
    days_abbr:["' . implode('","', $GLOBALS['TL_LANG']['DAYS_SHORT']) . '"]
  });
  Locale.define("en-US","DatePicker",{
    select_a_time:"' . $GLOBALS['TL_LANG']['DP']['select_a_time'] . '",
    use_mouse_wheel:"' . $GLOBALS['TL_LANG']['DP']['use_mouse_wheel'] . '",
    time_confirm_button:"' . $GLOBALS['TL_LANG']['DP']['time_confirm_button'] . '",
    apply_range:"' . $GLOBALS['TL_LANG']['DP']['apply_range'] . '",
    cancel:"' . $GLOBALS['TL_LANG']['DP']['cancel'] . '",
    week:"' . $GLOBALS['TL_LANG']['DP']['week'] . '"
  });
});
</script>';
	}
	
	
	protected function getScriptTag()
	{
		if (TL_MODE == 'BE')
		{
			return '<script>';
		}
		
		global $objPage;

		return $objPage->outputFormat == 'html' ? '<script>' : '<script type="text/javascript">';
	}
}

