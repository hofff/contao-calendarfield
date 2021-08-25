Contao Extension "hofff/contao-calendarfield"
---------------------------------------------
### Version 4.0.0 (2021-08-xx) ###
- Replaces jQuery with flatpickr (https://flatpickr.js.org/)  (see #50)
- Moved all options to the template (everything is customizable there and nothing hidden in PHP classes)
- Removed hook `formCalendarField` due to it is not longer necessary (everything could be modified in the template)
- Removed field `dateIncludeCSS` from configuration because at least a minimum CSS is needed
- Renamed field `dateIncludeCSSTheme` to `dateCssTheme` and added the new available theme names
- Added option to configure own min. and max. date dates (see #48)
- Added option to configure the image size for the icon (see #35)

### Version 3.0.2 (2018-02-07) ###
- Fixes probleme with `BLOB NOT NULL` field in Contao 4.5

### Version 3.0.1 (2017-11-20) ###
- Fixes determining the jQuery UI version (see #40)
- Fixes determining the translations for `en`

### Version 3.0.0 (2017-08-28) ###
- Adding Contao 4.4 compatibilty
- Adding PHP 7 compatibilty

### Version 2.2.3 (2017-08-25) ###
- Adjust the code to be compatible with PHP7 (see #37)

### Version 2.2.2 (2017-08-25) ###
- Fix probleme with duplicate assets url (see #33)

### Version 2.2.1 (2017-03-28) ###
- Fixing probleme with parameter `dateFormat` (see #36)

### Version 2.2.0 (2017-01-10) ###
- Adding optional definition of dates/weekdays, that should be disabled/not allowed
- Fixing console bugs in backend view
- Adding an individual default datepicker icon to remove dependeny to mootools
- Adding missing `tabindex` to DCA (see #34)

### Version 2.1.4 (2016-08-05) ###
- Fixes probleme with wrong JS config when using date limitations.

### Version 2.1.3 (2016-06-16) ###
- Fixing bug with correct integration of initialization script.

### Version 2.1.2 (2016-04-28) ###
- Fixed: Using jQuery and MooTools Together (see #30)

### Version 2.1.1 (2016-03-10) ###
- Removed checking attributes `disable` and `readonly`.

### Version 2.1.0 (2016-01-29) ###
- allow individual js config via `dateConfig` param

### Version 2.0.1 (2016-01-28) ###
- Adding default CSS (see #28)
- Removing jquery ui for Contao 3.2.x

### Version 2.0.0 (2016-01-28) ###
- Reordering folder structure

### Version 2.0.0-beta4 (2016-01-26) ###
- Adding correct template usage
- Restricting minimum Contao version do `3.3.x`
- Adding tooltip to calendar icon

### Version 2.0.0-beta3 (2016-01-25) ###
- Get `jquery.ui` theme CSS via `https`, to avoid errros with defined `TL_ASSETS_URL` variable

### Version 2.0.0-beta2 (2016-01-19) ###
- Renaming module folder
- Moving assets one folder up to improve manual updates
- Cleaning up code

### Version 2.0.0-beta1 (2015-12-23) ###
- Initial release