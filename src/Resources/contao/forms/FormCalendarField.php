<?php

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Hofff\Contao\Calendarfield;

class FormCalendarField extends \FormTextField
{
  const DATE_FORMAT_PHP = "d-m-Y";
  
  /**
   * Template
   *
   * @var string
   */
  protected $strTemplate = 'form_calendarfield';

  /**
   * The CSS class prefix
   *
   * @var string
   */
  protected $strPrefix = 'widget widget-text widget-calendar';
  
  /**
   * Always set rgxp to `date`
   *
   * @param array $arrAttributes An optional attributes array
   */
  public function __construct($arrAttributes = null)
  {
    parent::__construct($arrAttributes);

    $this->rgxp = 'date';
  }

  /**
   * Parse the template file and return it as string
   *
   * @param array $arrAttributes An optional attributes array
   *
   * @return string The template markup
   */
  public function parse($arrAttributes=null)
  {
    // do not add in back end
    if (TL_MODE == 'BE')
    {
      return parent::parse($arrAttributes);
    }

    global $objPage;

    // add the selector to the template
    $this->selector = "ctrl_" . $this->id;
    
    // add the language to the template
    $this->language = substr($objPage->language, 0, 2);

    // get the date format und add it to the template
    $dateFormat = $this->dateFormat ? $this->dateFormat : $objPage->dateFormat;
    if ($this->dateParseValue && $this->varValue != '')
    {
      $this->varValue = \Date::parse($dateFormat, strtotime($this->varValue));
    }
    $this->dateFormat = $dateFormat;

    // add the min/max date to the template
    switch ($this->dateDirection)
    {
      case 'ltToday': $this->maxDate = "new Date().fp_incr(-1)"; break;
      case 'leToday': $this->maxDate = "new Date().fp_incr(0)"; break;
      case 'geToday': $this->minDate = "new Date().fp_incr(0)"; break;
      case 'gtToday': $this->minDate = "new Date().fp_incr(1)"; break;
    }

    if ($this->dateImage) {
      if (\Validator::isUuid($this->dateImageSRC)) {
        $objFile = \FilesModel::findByPk($this->dateImageSRC);

        if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path)) {
          $strIcon = $objFile->path;
        }
      }

      $this->buttonImage = $strIcon;
      $this->buttonText = $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip'];
    }

    // <<<<< FIN >>>>>

    // correctly style the date format
    //$arrConfig['dateFormat'] = $this->dateformat_PHP_to_jQueryUI($dateFormat);

    //if (is_array($this->dateConfig)) {
    //  $arrConfig = array_replace($arrConfig, $this->dateConfig);
    //}


    $strConfig = json_encode($arrConfig);
    
    $beforeShowDayFunction .= <<<JS
function(date){
  var weekday = date.getDay().toString();
  var stringDate = jQuery.datepicker.formatDate('dd-mm-yy', date);
  var isWeekdayDisabled = ($.inArray(weekday, disabledWeekdays) != -1);
  var isDayDisabled = ($.inArray(stringDate, disabledDays) != -1);
  return [!isWeekdayDisabled && !isDayDisabled];
}
JS;
    
    $strConfig = substr($strConfig, 0, strlen($strConfig) - 1) . ',"beforeShowDay":' . sprintf($beforeShowDayFunction) . '}';
    
    // extract disallowed weekdays
    $disabledWeekdays = json_encode(deserialize($this->dateDisabledWeekdays, true));
    
    // extract disallowed days
    $disabledDays = json_encode($this->getActiveDisabledDays());
    
    $calendarfieldScript .= <<<JS
<script>
jQuery(function($) {
  var disabledWeekdays = $disabledWeekdays;
  var disabledDays = $disabledDays;
  $("#ctrl_%s").datepicker(%s);
  $("#ctrl_%s").datepicker( $.datepicker.regional["%s"] );
});
</script>
JS;

    return parent::parse($arrAttributes);
  }

  /**
   * Generate the widget and return it as string
   *
   * @return string The widget markup
   */
  public function generate()
  {
    return parent::generate();
  }

  public function validator($varInput)
  {
    $objToday = new \Date();

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
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_ltToday']);
          }
          break;
        case 'leToday':
          if ($intTstamp > $objToday->dayBegin) {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_leToday']);
          }
          break;
        case 'geToday':
          if ($intTstamp < $objToday->dayBegin) {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_geToday']);
          }
          break;
        case 'gtToday':
          if ($intTstamp <= $objToday->dayBegin) {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_gtToday']);
          }
          break;
      }
      
      //validate disallowed weekdays
      $disabledWeekdays = deserialize($this->dateDisabledWeekdays, true);
      if (in_array(date("w", $intTstamp), $disabledWeekdays))
      {
        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_disabled_weekday']);
      }
      
      //validate disallowed days
      if (in_array(date(static::DATE_FORMAT_PHP, $intTstamp), $this->getActiveDisabledDays()))
      {
        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_disabled_day']);
      }
    }

    return parent::validator($varInput);
  }

  /**
   * Return a regular expression that matches a particular date format
   *
   * @param bool|string $strFormat
   * @param string    $strRegexpSyntax
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
      throw new \Exception(sprintf('Invalid date format "%s"', $strFormat));
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
  
  private function getActiveDisabledDays()
  {
    $arrDateDisabledDays = deserialize($this->dateDisabledDays, true);
    $arrDateDisabledDaysActive = array();
    foreach ($arrDateDisabledDays as $config)
    {
      if (!empty($config['date']) && $config['active'])
      {
        $arrDateDisabledDaysActive[] = date(static::DATE_FORMAT_PHP, $config['date']);
      }
    }
    return $arrDateDisabledDaysActive;
  }
}