<?php

/**
 * Global Calendar Converter
 * This class use reflection to call two methods written in calendar's class.
 * All calendars class should extend BaseCalendar which is an abstract class.
 * According to BaseCalendar class all child class should have two functions :
 * 1- convertToUnixTimeStamp($format, $date)
 * 2- revertFromUnixTimeStamp($format, $timestamp)
 * Then we can convert all calendars to each other.
 *
 * @author Farhad Kia
 * @email farhad2161@yahoo.com
 */
class gCal {

    /**
     * Convert different calendars type to each other.
     * @param string $sourceFormat source date format.
     * @param string $sourceDate source date.
     * @param string $sourceCalendarName Class name of the source calendar. Call calendarName() from calendar's parent
     * class(BaseCalendar), this static method will return the name of child class.
     * @param string $destinationFormat Converted date will be return with this format.
     * @param string $destinationCalendarName Destination calendar class name. Call calendarName() from calendar's parent
     * class(BaseCalendar), this static method will return the name of child class.
     * @return string Converted date.
     */
    static function convert($sourceFormat, $sourceDate, $sourceCalendarName, $destinationFormat, $destinationCalendarName) {
        //Convert source date to Unix date
        $fromCalendarClass = new ReflectionClass($sourceCalendarName);
        $fromCalendar = $fromCalendarClass->newInstanceArgs();

        $unixDate = $fromCalendar->convertToUnixTimeStamp($sourceFormat, $sourceDate);

        //Convert unix date to destination date
        $toCalendarClass = new ReflectionClass($destinationCalendarName);
        $toCalendar = $toCalendarClass->newInstanceArgs();

        $destinationDate = $toCalendar->revertFromUnixTimeStamp($destinationFormat, $unixDate);

        return $destinationDate;
    }

}

?>