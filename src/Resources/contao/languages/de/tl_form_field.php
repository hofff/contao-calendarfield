<?php

/**
 * Form fields
 */
$GLOBALS['TL_LANG']['FFL']['calendarfield'] = array('Kalenderfeld', 'Formularfeld um eine Datumsauswahl im Frontend anzubieten.');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']             = array('Datumsformat', 'Der Datumsformat-String wird mit der PHP-Funktion date() geparst.');
$GLOBALS['TL_LANG']['tl_form_field']['dateCssTheme']           = array('Theme', 'Wählen Sie das zu verwendende Theme aus.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']          = array('Datumsrichtung', 'Wählen Sie ob die Datumsauswahl eingeschränkt werden soll.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionMinMax']    = array('Min. / max. Werte für Datum', 'Geben Sie eigene min. und max. Werte für das Datum an. Geben Sie die Tage als ganzzahlige Werte ein, welche ausgehend vom aktuellen Tag gelten. Mit negativen Werten wird rückwärts gerechnet.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']              = array('Kalender-Icon anzeigen', 'Wählen Sie ob ein Kalender-Icon angezeigt werden soll.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']           = array('Eigenes Icon', 'Wählen Sie ein Icon aus, welches statt dem Standardbild verwendet werden soll.');
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSize']          = array('Bildgröße', 'Legen Sie die Abmessungen des Bildes und den Skalierungsmodus fest.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledWeekdays']   = array('Nicht erlaubte Wochentage', 'Wählen Sie die Wochentage aus, die nicht erlaubt sind und somit nicht auswählbar sein sollen.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDays']       = array('Nicht erlaubte Tage', 'Wählen Sie die Daten der Tage aus, die nicht erlaubt sind und somit nicht auswählbar sein sollen.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysDate']   = array('Datum', 'Wählen Sie das Datum des Tages aus, die nicht erlaubt ist und somit nicht auswählbar sein sollen.');
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysActive'] = array('Aktiviert', 'Wählen Sie aus, ob diese Definition aktuell aktiv ist und verwendet werden soll oder nicht.');
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']         = array('Standard-Wert konvertieren', 'Den Standard-Wert mittels PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">strtotime()</a> analysieren.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['all']       = 'Alle Daten erlaubt';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['ltToday']   = 'Nur Datum in der Vergangenheit (exkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['leToday']   = 'Nur Datum in der Vergangenheit (inkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['geToday']   = 'Nur Datum in der Zukunft (inkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['gtToday']   = 'Nur Datum in der Zukunft (exkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['ownMinMax'] = 'Eigene min. und max Werte festlegen';
