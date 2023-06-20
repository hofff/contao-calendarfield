<?php

/**
 * Run in a custom namespace, so the class can be replaced
 */

namespace Hofff\Contao\Calendarfield;

use Contao\CoreBundle\Exception\InternalServerErrorException;
use Contao\Date;
use Contao\FilesModel;
use Contao\FormText;
use Contao\StringUtil;
use Contao\System;
use Contao\Validator;

class FormCalendarField extends FormText
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
  public function parse($arrAttributes = null)
  {
    // do not add in back end
    $request = System::getContainer()->get('request_stack')->getCurrentRequest();

    if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
    {
      return parent::parse($arrAttributes);
    }

    global $objPage;

    // add the language to the template
    $this->language = substr($objPage->language, 0, 2);

    // get the date format und add it to the template
    $dateFormat = $this->dateFormat ? $this->dateFormat : $objPage->dateFormat;
    if ($this->dateParseValue && $this->varValue != '')
    {
      $this->varValue = Date::parse($dateFormat, strtotime($this->varValue));
    }
    $this->dateFormat = $dateFormat;

    // add the min/max date to the template
    switch ($this->dateDirection)
    {
      case 'ltToday':
        $this->maxDate = "new Date().fp_incr(-1)";
        break;
      case 'leToday':
        $this->maxDate = "new Date().fp_incr(0)";
        break;
      case 'geToday':
        $this->minDate = "new Date().fp_incr(0)";
        break;
      case 'gtToday':
        $this->minDate = "new Date().fp_incr(1)";
        break;
      case 'ownMinMax':
        $arrMinMax = StringUtil::deserialize($this->dateDirectionMinMax, true);
        if (!empty($arrMinMax[0]))
        {
          $this->minDate = sprintf("new Date().fp_incr(%s)", $arrMinMax[0]);
        }
        if (!empty($arrMinMax[1]))
        {
          $this->maxDate = sprintf("new Date().fp_incr(%s)", $arrMinMax[1]);
        }
        break;
    }

    if ($this->dateImage)
    {
      $strIcon = '';
      if (Validator::isUuid($this->dateImageSRC))
      {
        $objModel = FilesModel::findByUuid($this->dateImageSRC);

        if ($objModel !== null && is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $objModel->path))
        {
          $strIcon = $objModel->path;
          $arrData = array(
            'singleSRC'   => $objModel->path,
            'size'        => $this->dateImageSize,
            'alt'         => $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip'],
            'imageTitle'  => $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip']
          );
          $this->addImageToTemplate($this, $arrData, null, null, $objModel);
        }
      }

      $this->buttonImage = $strIcon;
      $this->buttonText = $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip'];
    }

    // add the disallowed weekdays to the template
    $this->disabledWeekdays = StringUtil::deserialize($this->dateDisabledWeekdays, true);

    // add the disallowed days to the template
    $this->disabledDays = $this->getActiveDisabledDays($dateFormat);

    // add the custom configuration
    $this->customConfiguration = htmlspecialchars_decode($this->dateCustomConfiguration);

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
    $objToday = new Date();

    $intTstamp = 0;
    $dateFormat = $this->dateFormat ?: $GLOBALS['TL_CONFIG'][$this->rgxp . 'Format'];

    if ($varInput != '')
    {
      // Validate date format
      if ($this->dateFormat)
      {
        // Disable regular date validation
        $this->rgxp = '';

        if (strlen($varInput) && !preg_match('/' . $this->getRegexp($this->dateFormat) . '/i', $varInput))
        {
          $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['date'], $objToday->getInputFormat($this->dateFormat)));
        }
      }

      // Convert timestamps
      try
      {
        $objDate = new Date($varInput, $dateFormat);
        $intTstamp = $objDate->tstamp;
      }
      catch (\Exception $e)
      {
        $this->addError($e->getMessage());
      }

      switch ($this->dateDirection)
      {
        case 'ltToday':
          if ($intTstamp >= $objToday->dayBegin)
          {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_ltToday']);
          }
          break;
        case 'leToday':
          if ($intTstamp > $objToday->dayBegin)
          {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_leToday']);
          }
          break;
        case 'geToday':
          if ($intTstamp < $objToday->dayBegin)
          {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_geToday']);
          }
          break;
        case 'gtToday':
          if ($intTstamp <= $objToday->dayBegin)
          {
            $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_gtToday']);
          }
          break;
      }

      //validate disallowed weekdays
      $disabledWeekdays = StringUtil::deserialize($this->dateDisabledWeekdays, true);
      if (in_array(date("w", $intTstamp), $disabledWeekdays))
      {
        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_disabled_weekday']);
      }

      //validate disallowed days
      if (in_array(date(static::DATE_FORMAT_PHP, $intTstamp), $this->getActiveDisabledDays(static::DATE_FORMAT_PHP)))
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
  public function getRegexp($strFormat = false)
  {
    if (!$strFormat)
    {
      $strFormat = $GLOBALS['TL_CONFIG']['dateFormat'];
    }

    if (preg_match('/[BbCcDEeFfIJKkLlMNOoPpQqRrSTtUuVvWwXxZz]+/', $strFormat))
    {
      throw new InternalServerErrorException(sprintf('Invalid date format "%s"', $strFormat));
    }

    $strRegexp = '';
    $arrCharacters = str_split($strFormat);

    foreach ($arrCharacters as $strCharacter)
    {
      switch ($strCharacter)
      {
          // Patch day: allow 01 - 31
        case 'd':
          $strRegexp  .= '(0[1-9]|[12][0-9]|3[01])';
          break;

          // Patch month: allow 01 - 12
        case 'm':
          $strRegexp  .= '(0[1-9]|1[012])';
          break;

          // Patch year: allow 1900 - 2099
        case 'Y':
          $strRegexp  .= '(19|20)[0-9]{2,2}';
          break;

        case 'a':
        case 'A':
          $strRegexp  .= '[apmAPM]{2,2}';
          break;

        case 'y':
        case 'h':
        case 'H':
        case 'i':
        case 's':
          $strRegexp  .= '[0-9]{2,2}';
          break;

        case 'j':
        case 'n':
        case 'g':
        case 'G':
          $strRegexp  .= '[0-9]{1,2}';
          break;

        default:
          $strRegexp  .= preg_quote($strCharacter, '/');
          break;
      }
    }

    return $strRegexp;
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
    for ($i = 0; $i < strlen($php_format); $i++)
    {
      $char = $php_format[$i];
      if ($char === '\\') // PHP date format escaping character
      {
        $i++;
        if ($escaping) $jqueryui_format .= $php_format[$i];
        else $jqueryui_format .= '\'' . $php_format[$i];
        $escaping = true;
      }
      else
      {
        if ($escaping)
        {
          $jqueryui_format .= "'";
          $escaping = false;
        }
        if (isset($SYMBOLS_MATCHING[$char]))
          $jqueryui_format .= $SYMBOLS_MATCHING[$char];
        else
          $jqueryui_format .= $char;
      }
    }
    return $jqueryui_format;
  }

  private function getActiveDisabledDays($dateFormat)
  {
    $arrDateDisabledDays = StringUtil::deserialize($this->dateDisabledDays, true);
    $arrDateDisabledDaysActive = array();
    foreach ($arrDateDisabledDays as $config)
    {
      if (!empty($config['date']) && $config['active'])
      {
        $arrDateDisabledDaysActive[] = date($dateFormat, $config['date']);
      }
    }
    return $arrDateDisabledDaysActive;
  }
}
