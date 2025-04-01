<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['FFL']['calendarfield'] = [
    'Kalenderfeld',
    'Formularfeld um eine Datumsauswahl im Frontend anzubieten.',
];

$GLOBALS['TL_LANG']['tl_form_field']['dateFormat']              = [
    'Datumsformat',
    'Der Datumsformat-String wird mit der PHP-Funktion date() geparst.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateCssTheme']            = [
    'Theme',
    'Wählen Sie das zu verwendende Theme aus.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateDirection']           = [
    'Datumsrichtung',
    'Wählen Sie ob die Datumsauswahl eingeschränkt werden soll.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionMinMax']     = [
    'Min. / max. Werte für Datum',
    'Geben Sie eigene min. und max. Werte für das Datum an. Geben Sie die Tage als ganzzahlige Werte ein, welche'
    . ' ausgehend vom aktuellen Tag gelten. Mit negativen Werten wird rückwärts gerechnet.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateImage']               = [
    'Kalender-Icon anzeigen',
    'Wählen Sie ob ein Kalender-Icon angezeigt werden soll.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSRC']            = [
    'Eigenes Icon',
    'Wählen Sie ein Icon aus, welches statt dem Standardbild verwendet werden soll.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateImageSize']           = [
    'Bildgröße',
    'Legen Sie die Abmessungen des Bildes und den Skalierungsmodus fest.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledWeekdays']    = [
    'Nicht erlaubte Wochentage',
    'Wählen Sie die Wochentage aus, die nicht erlaubt sind und somit nicht auswählbar sein sollen.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDays']        = [
    'Nicht erlaubte Tage',
    'Wählen Sie die Daten der Tage aus, die nicht erlaubt sind und somit nicht auswählbar sein sollen.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysDate']    = [
    'Datum',
    'Wählen Sie das Datum des Tages aus, die nicht erlaubt ist und somit nicht auswählbar sein sollen.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateDisabledDaysActive']  = [
    'Aktiviert',
    'Wählen Sie aus, ob diese Definition aktuell aktiv ist und verwendet werden soll oder nicht.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateCustomConfiguration'] = [
    'Individuelle Konfiguration',
    'Bitte geben Sie eine individuelle Konfiguration des flatpickr.js Widgets ein. Dies muss gültiges <i>JSON</i> sein.'
    . ' Die hier eingegebene Konfiguration wird am Ende angehängt. Damit werden bereits vorhandene '
    . 'Konfigurationsoptionen von oben überschrieben. Weitere Informationen zu den Konfigurationsoptionen finden '
    . 'Sie in der Dokumentation unter <a href="https://flatpickr.js.org/options/">https://flatpickr.js.org</a>.',
];
$GLOBALS['TL_LANG']['tl_form_field']['dateParseValue']          = [
    'Standard-Wert konvertieren',
    'Den Standard-Wert mittels PHP <a href="http://php.net/strtotime" onclick="window.open(this.href); return false">'
    . 'strtotime()</a> analysieren.',
];

$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['all']       =
    'Alle Daten erlaubt';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['ltToday']   =
    'Nur Datum in der Vergangenheit (exkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['leToday']   =
    'Nur Datum in der Vergangenheit (inkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['geToday']   =
    'Nur Datum in der Zukunft (inkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['gtToday']   =
    'Nur Datum in der Zukunft (exkl. Heute)';
$GLOBALS['TL_LANG']['tl_form_field']['dateDirectionOptions']['ownMinMax'] =
    'Eigene min. und max Werte festlegen';
