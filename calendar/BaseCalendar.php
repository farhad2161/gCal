<?php

/**
 * This is an abstract class which all calendar class should extend it.
 *
 * @author Farhad Kia
 */
abstract class BaseCalendar {

    /**
     * return the name of class
     * @return string Class name
     */
    static function calendarName() {
        return get_called_class();
    }

    /**
     * In this method we convert a date to unix timestamp.
     */
    abstract function convertToUnixTimeStamp($format, $date);

    /**
     * In this method we convert unix timestamp to desired calendar date.
     */
    abstract function revertFromUnixTimeStamp($format, $timestamp);
}

?>
