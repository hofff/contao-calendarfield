Contao Extension "calendarfield"
--------------------------------

### Version 1.7.2 stable (2015-04-09) ###
- Fixed bug in update script

### Version 1.7.1 stable (2015-03-31) ###
- Fixed bug in update script

### Version 1.7.0 stable (2015-03-30) ###
- Added support for dates in the past including today (#18)
- Fixes problem when selecting option for all dates (#15)
- Added composer support

### Version 1.6.2 stable (2014-11-26) ###
- Fixed mandatory-check when using custom date format (#17)

### Version 1.6.1 stable (2014-10-13) ###
- Fixed date validation when no custom date format is set

### Version 1.6.0 stable (2014-10-10) ###
- Added Contao 3.3 compatibility
- Added support for placeholder attribute
- Added date validation for future-/past-only input
- Dropped support for Contao 2.11/3.0/3.1

### Version 1.5.0 stable (2014-01-14) ###
- Added option to select date in the future including today
- Added option to disable inclusion of style sheet (#10)
- Added option to force use of the date picker

### Version 1.4.1 stable (2013-09-25) ###
- Fixed custom icon not being considered (#7)

### Version 1.4.0 stable (2013-09-25) ###
- Fixed call to `method_exists` (#6)
- Fixed PHP version incompatibility

### Version 1.4.0 RC1 (2012-10-02) ###
- Removed support for Contao 2.9 and 2.10
- Added support for Contao 3
- Allow to set a custom icon using eval->icon
- Draggable can now be defined using eval->draggable
- Offsets can now also be configured using eval->offsetX and eval->offsetY
- Applied the Locale so labels get translated
- Allow to hiding the calendar icon
- Added hook "formCalendarField" to add custom config


### Version 1.3.0 (2011-09-22) ###
- Added support for Contao 2.10 datepicker script (Ticket #1939)
- Can now pick date, time and date/time
- Officially removed support for TYPOlight 2.7


### Version 1.2.0 (2011-04-15) ###
- The default value can be parsed with strtotime(). This allows for default values like "+2 days".
- Added ability to use the widget with custom javascript event (useful for ajax applications).


### Version 1.1.2 (2010-02-20) ###
- Resolves the problem with TYPOlight 2.8 where the path to the calendar plugin has changed.


### Version 1.1.1 (2009-07-01) ###
- Fixes the problem where TYPOlight displays an error message for the system date format even if you have set your own format.


### Version 1.1.0 (2009-05-12) ###
- Can set a custom date format for the field. If none is set, the default date format is taken.
- Can set if only future or past dates are allowed to select


### Version 1.0.0 (2009-02-16) ###
- Initial release