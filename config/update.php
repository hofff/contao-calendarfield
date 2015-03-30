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

class CalendarfieldUpdate extends Controller
{
    private $db;

    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();

        $this->db = \Database::getInstance();
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
     * Migrate old values for date direction
     */
    private function updateTo170()
    {
        if (!$this->Database->fieldExists('dateDirection', 'tl_form_field')) {
            return;
        }

        $strQuery = "UPDATE tl_form_field %s WHERE dateDirection = ? AND type = 'calendar'";
        $arrSet = array();

        $arrSet['dateDirection'] = 'all';
        $this->db->prepare($strQuery)->set($arrSet)->execute("0");

        $arrSet['dateDirection'] = 'geToday';
        $this->db->prepare($strQuery)->set($arrSet)->execute("+0");

        $arrSet['dateDirection'] = 'gtToday';
        $this->db->prepare($strQuery)->set($arrSet)->execute("+1");

        $arrSet['dateDirection'] = 'ltToday';
        $this->db->prepare($strQuery)->set($arrSet)->execute("-1");
    }
}


/**
 * Instantiate controller
 */
$objCalendarfieldUpdate = new CalendarfieldUpdate();
$objCalendarfieldUpdate->run();