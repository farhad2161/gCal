<?php

require_once 'BaseCalendar.php';

/**
 * This is a sample class in order to add your desired calendar to gCal.
 * This class should extends BaseCalendar class and shuld contain all abstract class which
 * is in BaseCalendar.
 *
 * @author Your name
 */
class Sample extends BaseCalendar {

    /**
     * Calculate count of days between Millenium(2000-01-01) and input date.
     * @param int $year Desired year
     * @param int $month Desired month
     * @param int $day Desired day
     * @return int $count Positive or negative gap between Millenium(2000-01-01) and input date
     */
    public function gapUntilMillenium($year, $month, $day) {
        //Calculate and return positive or negative count of days between input date and Millenium(2000-01-01).
        //If input date is after millenium return positive days count
        //else return a negative count
    }

    /**
     * Calculate the destination date according to the gap between destination date and Millenium(2000-01-01).
     * @param int $daysUntilMillenium count of days between desired date and Millenium(2000-01-01)
     * @return array $date Return date in an array exactly like array('year' => $year, 'month' => $month, 'day' => $day)
     */
    public function revertFromMillenium($daysUntilMillenium) {
        //Check $daysUntilMillenium is positive or negative to determine date is before Millenium(2000-01-01) or after.
        if ($daysUntilMillenium > 0) {
            //Do some stuff to find date in your desired calendar
        } else {
            //Do some stuff to find date in your desired calendar
        }

        return array('year' => $year, 'month' => $month, 'day' => $day);
    }

    /**
     * Convert date string to date array according to the format.
     * Override this method if you have something special in your date or format.
     * @param string $format Format of the date.
     * @param string $date A date for convert to array.
     * @return array Return an array that contain year, month, day, hour, minute and second.
     */
    function dateToArray($format, $date) {
        //Override this metho if you have something special in your calendar date format
        //else remove this method and let parent class do that.
        return parent::dateToArray($format, $date);
    }

    /**
     * Convert an array date that contain year, month, day, hour, minute and second to date string according to the out format.
     * Override this method if you have something special in your date or format.
     * @param array $date An array date that contain year, month, day, hour, minute and second.
     * @param string $outFormat A format string for convert date to it.
     * @return string Return a date string.
     */
    function ArrayToDate(array $date, $outFormat) {
        //Override this method if you have something special in your calendar date format
        //else remove this method and let parent class do that.
        return parent::ArrayToDate($date, $outFormat);
    }

    /**
     * Check whether date is in correct format and is valid.
     * Override this method if you have something special in your date or format.
     * @param string $format Format of the date.
     * @param string $date A date for validate.
     * @return boolean Return true if date is valid else false.
     */
    function isValidDate($format, $date) {
        //Validate a date according to format string and calendar rules
        //return a boolean value to indicate whether date is in correct format or not
        return parent::ArrayToDate($date, $outFormat);
    }

}

?>
