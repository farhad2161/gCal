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
     * Calculate the count of days between source date and millenium(2000-01-01)
     */
    abstract function gapUntilMillenium($year, $month, $day);

    /**
     * Calculate destination date from days until millenuim(2000-01-01)
     */
    abstract function revertFromMillenium($daysUntilMillenium);

    /**
     * Convert date string to date array according to the format.
     * Override this method if you have something special in your date or format.
     * @param string $format Format of the date.
     * @param string $date A date for convert to array.
     * @return array Return an array that contain year, month, day, hour, minute and second.
     */
    function dateToArray($format, $date) {
        return date_parse_from_format($format, $date);
    }

    /**
     * Convert an array date that contain year, month, day, hour, minute and second to date string according to the out format.
     * Override this method if you have something special in your date or format.
     * @param array $date An array date that contain year, month, day, hour, minute and second.
     * @param string $outFormat A format string for convert date to it.
     * @return string Return a date string.
     */
    function ArrayToDate(array $date, $outFormat) {
        $date = new DateTime(str_pad($date['year'], 4, '0', STR_PAD_LEFT) . '-' .
                str_pad($date['month'], 2, '0', STR_PAD_LEFT) . '-' .
                str_pad($date['day'], 2, '0', STR_PAD_LEFT) . ' ' .
                str_pad($date['hour'], 2, '0', STR_PAD_LEFT) . ':' .
                str_pad($date['minute'], 2, '0', STR_PAD_LEFT) . ':' .
                str_pad($date['second'], 2, '0', STR_PAD_LEFT));
        return $date->format($outFormat);
    }

    /**
     * Check whether date is in correct format and is valid.
     * Override this method if you have something special in your date or format.
     * @param string $format Format of the date.
     * @param string $date A date for validate.
     * @return boolean Return true if date is valid else false.
     */
    function isValidDate($format, $date) {
        //Do sum stuff to check date is valid
        return TRUE;
    }

}

?>
