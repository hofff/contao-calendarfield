<?php

/**
 * Extension for Contao Open Source CMS
 *
 * Copyright (C) 2009 - 2015 terminal42 gmbh
 *
 * @package    Calendarfield
 * @link       http://www.terminal42.ch
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

class CalendarfieldRunOnce extends Controller
{

    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }


    /**
     * Run the controller
     */
    public function run()
    {
        $this->updateTo170();
    }


    /**
     * Update to version 1.7.0
     */
    private function updateTo170()
    {
        // migrate old values for date direction
        $strQuery = "UPDATE tl_form_field %s WHERE dateDirection = ? AND type = 'calendar'";
        $arrSet = array();

        $arrSet['dateDirection'] = 'all';
        $this->Database->prepare($strQuery)
             ->set($arrSet)
             ->execute("0");

        $arrSet['dateDirection'] = 'geToday';
        $this->Database->prepare($strQuery)
             ->set($arrSet)
             ->execute("+0");

        $arrSet['dateDirection'] = 'gtToday';
        $this->Database->prepare($strQuery)
             ->set($arrSet)
             ->execute("+1");

        $arrSet['dateDirection'] = 'ltToday';
        $this->Database->prepare($strQuery)
             ->set($arrSet)
             ->execute("-1");
    }
}


/**
 * Instantiate controller
 */
$objCalendarfieldRunOnce = new CalendarfieldRunOnce();
$objCalendarfieldRunOnce->run();