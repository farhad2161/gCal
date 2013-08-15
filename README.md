gCal
====

Php Global Calendar Convert - convert all calendar type to each other so simple.

What is gCal
------------

Global calendar is simple code to translate all calendars like Solar Hijri, Gregorian and ...
to each other. gCal try to convert source calendars to Unix timestamp and then convert the
Unix time to destination calendar.

How to add your calendar
------------------------

There is a Sample Class in `calendar` folder. All thing you need to create your new
calendar type is to create a class like `Sample.php` and extend it from `BaseCalendar.php`.
`BaseCalendar` is an abstract class and you should implement to method for it to work:

1.  function convertToUnixTimeStamp($format, $date)
2.  function revertFromUnixTimeStamp($format, $timestamp)

After implementing this two method, `convert` method in `gCal.php` will convert date
by calling your implemented methods via reflection.

How to use
----------
Just call the static `convert` method from `gCal.php`

    $solarHijri = '1392/05/24 11:01:02';
    //convert to Gregorian
    gCal::convert('Y/m/d H:i:s', $solarHijri, SolarHijri::calendarName(), 'Y-m-d H:i:s', Gregorian::calendarName());


Requirement
-----------

>*   PHP 5.3+

Note
----
There are some important bugs in `SolarHijri`. Do not use it for production yet.

Useful Links
------------
[UnixTime](http://en.wikipedia.org/wiki/Unix_time "Unix Time")
[date_parse_from_format](http://php.net/manual/en/function.date-parse-from-format.php "date_parse_from_format")
[createfromformat](http://php.net/manual/en/datetime.createfromformat.php "createfromformat")

More
----
Fork and add your calendar.
Thanks