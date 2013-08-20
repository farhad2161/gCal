gCal
====

Php Global Calendar Convert - convert all calendar type to each other so simple.

What is gCal
------------

Global calendar is simple code to convert all calendars like Solar Hijri(Shamsi,Jalali,... ), Gregorian and ...
to each other. gCal try to find the count of days between source calendar and Millenium(2000-01-01), then calculate the
the destination calendar according to this gap.

For example, in order to convert 1392/05/28 from Solar Hijri to Gregorian we do this stuff

1.  Find equivalent to millenium(2000-01-01) in Solar Hijri.(1378-10-11 is equal to 2000-01-01)
2.  Calculate count of days between 1392/05/28 and 1378-10-11 (Should be positive or negative). We do this in `gapUntilMillenium` method and result should be 4979.
3.  Calculate destination calendar by adding 4979 to equivalent millenium date(In Gregorian 2000-01-01 is equal to millenium(2000-01-01)).We do this in `revertFromMillenium` method and result should be 2013-08-19.

How to add your calendar
------------------------

There is a Sample Class in `calendar` folder. All thing you need to create your new
calendar type is to create a class like `Sample.php` and extend it from `BaseCalendar.php`.
`BaseCalendar` is an abstract class and you should implement to method for it to work:

1.  function gapUntilMillenium($year, $month, $day)
2.  function revertFromMillenium($daysUntilMillenium)

After implementing this two method, `convert` method in `gCal.php` will convert date
by calling your implemented methods via reflection.

How to use
----------
Just call the static `convert` method from `gCal.php`

    function convert(
        $sourceFormat, $sourceDate, $sourceCalendarName,
        $destinationFormat, $destinationCalendarName
    )

    $solarHijri = '1392/05/24 11:01:02';
    //convert to Gregorian
    gCal::convert(
        'Y/m/d H:i:s', $solarHijri, SolarHijri::calendarName(),
        'Y-m-d H:i:s', Gregorian::calendarName()
    );


Requirement
-----------

>*   PHP 5.3+

More
----
Request for pull or fork and add your calendar.
Thanks