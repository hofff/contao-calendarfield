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

        if ($this->rgxp != 'datim' && $this->rgxp != 'time') {
            $this->rgxp = 'date';
        }
    }

    public function generate()
    {
        if (!$this->dateExcludeCSS) {
            $GLOBALS['TL_CSS'][] = 'assets/mootools/datepicker/'.DATEPICKER.'/' . (version_compare(VERSION, '3.3', '>=') ? 'datepicker.css' : 'dashboard.css');
        }

        $GLOBALS['TL_JAVASCRIPT'][] = 'assets/mootools/datepicker/'.DATEPICKER.'/datepicker.js';

        $dateFormat = $this->dateFormat ?: $GLOBALS['TL_CONFIG'][$this->rgxp . 'Format'];
        $dateDirection = $this->dateDirection ?: '0';
        $jsEvent = $this->jsevent ?: 'domready';

        if ($this->dateParseValue && $this->varValue != '') {
            $this->varValue = \Date::parse($dateFormat, strtotime($this->varValue));
        }

        $strBuffer = parent::generate();

        if ($this->readonly || $this->disabled) {
            return $strBuffer;
        }

        // in the back end this is inlcuded automatically
        if (TL_MODE == 'FE') {
            $GLOBALS['TL_HEAD'][] = $this->getDateString();
        }

        // Initialize the default config
        $arrConfig = array(
            'draggable'    => (($this->draggable) ? "'true'" : "'false'"),
            'pickerClass'  => (version_compare(VERSION, '3.3', '>=') ? "'datepicker_bootstrap'" : "'datepicker_dashboard'"),
            'useFadeInOut' => "'!Browser.ie'",
            'startDay'     => $GLOBALS['TL_LANG']['MSC']['weekOffset'],
            'titleFormat'  => "'{$GLOBALS['TL_LANG']['MSC']['titleFormat']}'",
        );

        switch ($this->rgxp) {

            case 'datim':
                $arrConfig['timePicker'] = 'true';
                break;

            case 'time':
                $arrConfig['pickOnly'] = 'time';
                break;
        }

        switch ($dateDirection) {
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

        // default Offset
        $intOffsetX = 0;
        $intOffsetY = 0;

        // seems to be necessary for the backend but does only hurt in the FE
        $style = (TL_MODE == 'BE') ? ' style="vertical-align:-6px;"' : '';

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

            $strBuffer .= '<img src="' . $strIcon . '" width="' . $arrSize[0] . '" height="' . $arrSize[1] . '" alt="" class="JCalendarFieldIcon" id="toggle_' . $this->strId . '"' . $style . '>';

            $arrConfig['toggle'] = "$$('#toggle_" . $this->strId . "')";

            if ($this->dateImageOnly) {
                $arrConfig['togglesOnly'] = 'false';
            }

            // make offsets configurable (useful for the front end but can be used in the back end as well)
            $intOffsetX = -197;
            $intOffsetY = -182;
        }

        // make offsets configurable (useful for the front end but can be used in the back end as well)
        $intOffsetX = (is_numeric($this->offsetX)) ? $this->offsetX : $intOffsetX;
        $intOffsetY = (is_numeric($this->offsetY)) ? $this->offsetY : $intOffsetY;
        $arrConfig['positionOffset'] = '{x:' . $intOffsetX . ',y:' . $intOffsetY . '}';

        // correctly style the date format
        $arrConfig['format'] = "'" . Date::formatToJs($dateFormat) . "'";

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
window.addEvent('" . $jsEvent . "', function() {
  new Picker.Date($$('#ctrl_" . $this->strId . "'), {
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
        $dateDirection = $this->dateDirection ?: '0';

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

            switch ($dateDirection) {
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


    /**
     * Return the datepicker string
     *
     * Fix the MooTools more parsers which incorrectly parse ISO-8601 and do
     * not handle German date formats at all.
     * @return string
     */
    public function getDateString()
    {
        return '
<script>
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
}

