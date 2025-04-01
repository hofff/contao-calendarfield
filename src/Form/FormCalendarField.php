<?php

declare(strict_types=1);

namespace Hofff\CalendarfieldBundle\Form;

use Contao\CoreBundle\Exception\InternalServerErrorException;
use Contao\CoreBundle\File\Metadata;
use Contao\Date;
use Contao\FilesModel;
use Contao\FormText;
use Contao\StringUtil;
use Contao\System;
use Contao\Validator;
use Exception;
use Throwable;

use function date;
use function htmlspecialchars_decode;
use function in_array;
use function is_file;
use function is_string;
use function preg_match;
use function preg_quote;
use function sprintf;
use function str_split;
use function strlen;
use function strtotime;
use function substr;

class FormCalendarField extends FormText
{
    private const DATE_FORMAT_PHP = 'd-m-Y';

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
     * @param array<string, mixed>|null $arrAttributes An optional attributes array
     */
    public function __construct(array|null $arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->rgxp = 'date';
    }

    /**
     * Parse the template file and return it as string
     *
     * @param array<string, mixed>|null $arrAttributes An optional attributes array
     */
    public function parse(array|null $arrAttributes = null): string
    {
        // do not add in back end
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            return parent::parse($arrAttributes);
        }

        // add the language to the template
        $this->language = substr($GLOBALS['objPage']->language, 0, 2);

        // get the date format und add it to the template
        $dateFormat = $this->dateFormat ?: $GLOBALS['objPage']->dateFormat;
        if ($this->dateParseValue && $this->varValue !== '') {
            $this->varValue = Date::parse($dateFormat, strtotime($this->varValue));
        }

        $this->dateFormat = $dateFormat;

        // add the min/max date to the template
        switch ($this->dateDirection) {
            case 'ltToday':
                $this->maxDate = 'new Date().fp_incr(-1)';
                break;
            case 'leToday':
                $this->maxDate = 'new Date().fp_incr(0)';
                break;
            case 'geToday':
                $this->minDate = 'new Date().fp_incr(0)';
                break;
            case 'gtToday':
                $this->minDate = 'new Date().fp_incr(1)';
                break;
            case 'ownMinMax':
                $arrMinMax = StringUtil::deserialize($this->dateDirectionMinMax, true);
                if (! empty($arrMinMax[0])) {
                    $this->minDate = sprintf('new Date().fp_incr(%s)', $arrMinMax[0]);
                }

                if (! empty($arrMinMax[1])) {
                    $this->maxDate = sprintf('new Date().fp_incr(%s)', $arrMinMax[1]);
                }

                break;
        }

        if ($this->dateImage) {
            $strIcon = '';
            if (Validator::isUuid($this->dateImageSRC)) {
                $fileModel  = FilesModel::findByUuid($this->dateImageSRC);
                $projectDir = System::getContainer()->getParameter('kernel.project_dir');

                if ($fileModel !== null && is_file($projectDir . '/' . $fileModel->path)) {
                    $strIcon = $fileModel->path;
                    System::getContainer()
                        ->get('contao.image.studio')
                        ->createFigureBuilder()
                        ->fromFilesModel($fileModel)
                        ->setSize($this->dataImageSize)
                        ->setMetadata(
                            new Metadata(
                                [
                                    Metadata::VALUE_ALT   => $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip'],
                                    Metadata::VALUE_TITLE => $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip'],
                                ],
                            ),
                        )
                        ->build()
                        ->applyLegacyTemplateData($this);
                }
            }

            $this->buttonImage = $strIcon;
            $this->buttonText  = $GLOBALS['TL_LANG']['MSC']['calendarfield_tooltip'];
        }

        // add the disallowed weekdays to the template
        $this->disabledWeekdays = StringUtil::deserialize($this->dateDisabledWeekdays, true);

        // add the disallowed days to the template
        $this->disabledDays = $this->getActiveDisabledDays($dateFormat);

        // add the custom configuration
        $this->customConfiguration = htmlspecialchars_decode($this->dateCustomConfiguration);

        return parent::parse($arrAttributes);
    }

    public function validator(mixed $varInput): mixed
    {
        $today      = new Date();
        $timestamp  = 0;
        $dateFormat = $this->dateFormat ?: $GLOBALS['TL_CONFIG'][$this->rgxp . 'Format'];

        if (is_string($varInput) && $varInput !== '') {
            // Validate date format
            if ($this->dateFormat) {
                // Disable regular date validation
                $this->rgxp = '';

                if (
                    strlen($varInput)
                    && ! preg_match('/' . $this->getRegexp($this->dateFormat) . '/i', $varInput)
                ) {
                    $this->addError(
                        sprintf($GLOBALS['TL_LANG']['ERR']['date'], $today->getInputFormat($this->dateFormat)),
                    );
                }
            }

            // Convert timestamps
            try {
                $objDate   = new Date($varInput, $dateFormat);
                $timestamp = $objDate->tstamp;
            } catch (Throwable $exception) {
                $this->addError($exception->getMessage());
            }

            switch ($this->dateDirection) {
                case 'ltToday':
                    if ($timestamp >= $today->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_ltToday']);
                    }

                    break;
                case 'leToday':
                    if ($timestamp > $today->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_leToday']);
                    }

                    break;
                case 'geToday':
                    if ($timestamp < $today->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_geToday']);
                    }

                    break;
                case 'gtToday':
                    if ($timestamp <= $today->dayBegin) {
                        $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_direction_gtToday']);
                    }

                    break;
            }

            //validate disallowed weekdays
            $disabledWeekdays = StringUtil::deserialize($this->dateDisabledWeekdays, true);
            if (in_array(date('w', $timestamp), $disabledWeekdays)) {
                $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_disabled_weekday']);
            }

            //validate disallowed days
            if (
                in_array(
                    date(self::DATE_FORMAT_PHP, $timestamp),
                    $this->getActiveDisabledDays(self::DATE_FORMAT_PHP),
                )
            ) {
                $this->addError($GLOBALS['TL_LANG']['ERR']['calendarfield_disabled_day']);
            }
        }

        return parent::validator($varInput);
    }

    /**
     * Return a regular expression that matches a particular date format
     *
     * @throws Exception
     */
    private function getRegexp(string|bool $format = false): string
    {
        if (! $format) {
            $format = $GLOBALS['TL_CONFIG']['dateFormat'];
        }

        if (preg_match('/[BbCcDEeFfIJKkLlMNOoPpQqRrSTtUuVvWwXxZz]+/', $format)) {
            throw new InternalServerErrorException(sprintf('Invalid date format "%s"', $format));
        }

        $strRegexp     = '';
        $arrCharacters = str_split($format);

        foreach ($arrCharacters as $strCharacter) {
            switch ($strCharacter) {
                // Patch day: allow 01 - 31
                case 'd':
                    $strRegexp .= '(0[1-9]|[12][0-9]|3[01])';
                    break;

                // Patch month: allow 01 - 12
                case 'm':
                    $strRegexp .= '(0[1-9]|1[012])';
                    break;

                // Patch year: allow 1900 - 2099
                case 'Y':
                    $strRegexp .= '(19|20)[0-9]{2,2}';
                    break;

                case 'a':
                case 'A':
                    $strRegexp .= '[apmAPM]{2,2}';
                    break;

                case 'y':
                case 'h':
                case 'H':
                case 'i':
                case 's':
                    $strRegexp .= '[0-9]{2,2}';
                    break;

                case 'j':
                case 'n':
                case 'g':
                case 'G':
                    $strRegexp .= '[0-9]{1,2}';
                    break;

                default:
                    $strRegexp .= preg_quote($strCharacter, '/');
                    break;
            }
        }

        return $strRegexp;
    }

    /** @return list<string> */
    private function getActiveDisabledDays(string $dateFormat): array
    {
        $disabledDays       = StringUtil::deserialize($this->dateDisabledDays, true);
        $disabledDaysActive = [];

        foreach ($disabledDays as $config) {
            if (empty($config['date']) || ! $config['active']) {
                continue;
            }

            $disabledDaysActive[] = date($dateFormat, $config['date']);
        }

        return $disabledDaysActive;
    }
}
