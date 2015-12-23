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


class FormJCalendarField extends FormTextField
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'form_widget';

    public function __construct($arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->rgxp = 'date';
    }

    public function generate()
    {
        global $objPage;
        
       if ($this->dateIncludeCSS) {
            if (strlen($this->dateIncludeCSSTheme) > 0) {
                $GLOBALS['TL_CSS'][] = '//code.jquery.com/ui/'.JQUERY_UI.'/themes/' . $this->dateIncludeCSSTheme . '/jquery-ui.css';
            } else {
                $GLOBALS['TL_CSS'][] = TL_ASSETS_URL . 'assets/jquery/ui.datepicker/'.JQUERY_UI.'/jquery.ui.datepicker.min.css';
            }
        }

        $GLOBALS['TL_JAVASCRIPT'][] = TL_ASSETS_URL . 'assets/jquery/ui/'.JQUERY_UI.'/jquery-ui.min.js';
        $GLOBALS['TL_JAVASCRIPT'][] = TL_ASSETS_URL . 'assets/jquery/ui.datepicker/'.JQUERY_UI.'/jquery.ui.datepicker.min.js';
        $GLOBALS['TL_JAVASCRIPT'][] = TL_ASSETS_URL . 'assets/jquery/ui.datepicker/'.JQUERY_UI.'/i18n/jquery.ui.datepicker-' . $objPage->language . '.js';

        $dateFormat = $this->dateFormat ?: $GLOBALS['TL_CONFIG'][$this->rgxp . 'Format'];

        if ($this->dateParseValue && $this->varValue != '') {
            $this->varValue = \Date::parse($dateFormat, strtotime($this->varValue));
        }

        $strBuffer = parent::generate();

        if ($this->readonly || $this->disabled) {
            return $strBuffer;
        }

        // Initialize the default config
        $arrConfig = array(
            'showAnim'          => "'fadeIn'",
            'showOtherMonths'   => "true",
            'selectOtherMonths' => "true",
            'changeMonth'       => "true",
            'changeYear'        => "true"
        );

        switch ($this->dateDirection) {
            case 'ltToday':
                $time = strtotime('-1 day');
                $arrConfig['maxDate'] = 'new Date(' . date('Y', $time) . ', ' . (date('n', $time)-1) . ', ' . date('j', $time) . ')';
                break;

            case 'leToday':
                $arrConfig['maxDate'] = 'new Date(' . date('Y') . ', ' . (date('n')-1) . ', ' . date('j') . ')';
                break;

            case 'geToday':
                $arrConfig['minDate'] = 'new Date(' . date('Y') . ', ' . (date('n')-1) . ', ' . date('j') . ')';
                break;

            case 'gtToday':
                $time = strtotime('+1 day');
                $arrConfig['minDate'] = 'new Date(' . date('Y', $time) . ', ' . (date('n', $time)-1) . ', ' . date('j', $time) . ')';
                break;
        }

        // seems to be necessary for the backend but does only hurt in the FE
        $style = (TL_MODE == 'BE') ? ' style="vertical-align:-6px;"' : '';

        $strIcon = '';
        if ($this->dateImage) {
            // icon
            $strIcon = 'assets/mootools/datepicker/'.DATEPICKER.'/icon.gif';

            if (\Validator::isUuid($this->dateImageSRC)) {
                $objFile = \FilesModel::findByPk($this->dateImageSRC);

                if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path)) {
                    $strIcon = $objFile->path;
                }
            }

            $arrSize = @getimagesize(TL_ROOT . '/' . $strIcon);

            $arrConfig['showOn'] = "'both'";
            $arrConfig['buttonImage'] = "'" . $strIcon . "'";
            $arrConfig['buttonImageOnly'] = "true";
        }

        // HOOK: allow to customize the date picker
        if (isset($GLOBALS['TL_HOOKS']['formJCalendarField']) && is_array($GLOBALS['TL_HOOKS']['formJCalendarField'])) {
            foreach ($GLOBALS['TL_HOOKS']['formJCalendarField'] as $callback) {
                $objCallback = (method_exists($callback[0], 'getInstance') ? call_user_func(array($callback[0], 'getInstance')) : new $callback[0]());
                $arrConfig = $objCallback->$callback[1]($arrConfig, $this);
            }
        }


        $arrCompiledConfig = array();
        foreach ($arrConfig as $k => $v) {
            $arrCompiledConfig[] = "    '" . $k . "': " . $v;
        }

        $strBuffer .= "
<script>
$(function() {
  $.datepicker.regional['" . $objPage->language . "'];
  $('#ctrl_" . $this->strId . "').datepicker({
" . implode(",\n", $arrCompiledConfig) . "
  });
});
</script>";

        return $strBuffer;
    }

    public function validator($varInput)
    {
        $objToday = new Date();

        $intTstamp = 0;
        $dateFormat = $this->dateFormat ?: $GLOBALS['TL_CONFIG'][$this->rgxp . 'Format'];

        if ($varInput != '') {

            // Validate date format
            if ($this->dateFormat) {

                // Disable regular date validation
                $this->rgxp = '';

                if (strlen($varInput) && !preg_match('/'. $this->getRegexp($this->dateFormat) .'/i', $varInput)) {
                    $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['date'], $objToday->getInputFormat($this->dateFormat)));
                }
            }

            // Convert timestamps
            try {
                $objDate = new \Date($varInput, $dateFormat);
                $intTstamp = $objDate->tstamp;
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
            }

            switch ($this->dateDirection) {
                case 'ltToday':
                    if ($intTstamp >= $objToday->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['jcalendarfield_direction_ltToday']);
                    }
                    break;
                case 'leToday':
                    if ($intTstamp > $objToday->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['jcalendarfield_direction_leToday']);
                    }
                    break;
                case 'geToday':
                    if ($intTstamp < $objToday->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['jcalendarfield_direction_geToday']);
                    }
                    break;
                case 'gtToday':
                    if ($intTstamp <= $objToday->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['jcalendarfield_direction_+1']);
                    }
                    break;
            }
        }

        return parent::validator($varInput);
    }


    /**
     * Return a regular expression that matches a particular date format
     *
     * @param bool|string $strFormat
     * @param string      $strRegexpSyntax
     *
     * @throws Exception
     * @return string
     */
    public function getRegexp($strFormat = false, $strRegexpSyntax = 'perl')
    {
        if (!$strFormat) {
            $strFormat = $GLOBALS['TL_CONFIG']['dateFormat'];
        }

        if (preg_match('/[BbCcDEeFfIJKkLlMNOoPpQqRrSTtUuVvWwXxZz]+/', $strFormat)) {
            throw new Exception(sprintf('Invalid date format "%s"', $strFormat));
        }

        $arrRegexp = array();
        $arrCharacters = str_split($strFormat);

        foreach ($arrCharacters as $strCharacter) {
            switch ($strCharacter) {

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


    /*
     * Matches each symbol of PHP date format standard
     * with jQuery equivalent codeword
     * @author Tristan Jahier
     */
    private function dateformat_PHP_to_jQueryUI($php_format)
    {
        $SYMBOLS_MATCHING = array(
            // Day
            'd' => 'dd',
            'D' => 'D',
            'j' => 'd',
            'l' => 'DD',
            'N' => '',
            'S' => '',
            'w' => '',
            'z' => 'o',
            // Week
            'W' => '',
            // Month
            'F' => 'MM',
            'm' => 'mm',
            'M' => 'M',
            'n' => 'm',
            't' => '',
            // Year
            'L' => '',
            'o' => '',
            'Y' => 'yy',
            'y' => 'y',
            // Time
            'a' => '',
            'A' => '',
            'B' => '',
            'g' => '',
            'G' => '',
            'h' => '',
            'H' => '',
            'i' => '',
            's' => '',
            'u' => ''
        );
        $jqueryui_format = "";
        $escaping = false;
        for($i = 0; $i < strlen($php_format); $i++)
        {
            $char = $php_format[$i];
            if($char === '\\') // PHP date format escaping character
            {
                $i++;
                if($escaping) $jqueryui_format .= $php_format[$i];
                else $jqueryui_format .= '\'' . $php_format[$i];
                $escaping = true;
            }
            else
            {
                if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
                if(isset($SYMBOLS_MATCHING[$char]))
                    $jqueryui_format .= $SYMBOLS_MATCHING[$char];
                else
                    $jqueryui_format .= $char;
            }
        }
        return $jqueryui_format;
    }
}