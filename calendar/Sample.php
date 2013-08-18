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

    public function convertToUnixTimeStamp($format, $date) {

        //Convert date to year,month,day,hour,minute second array .
        //Read more here : http://php.net/manual/en/function.date-parse-from-format.php
        $arrayDate = date_parse_from_format($format, $date);

        //Find equivalent of your calendar epoch time
        //1970-01-01 01:00:00 is equal to ? your calendar
        //Read more here : http://en.wikipedia.org/wiki/Unix_time
        //Finally find the equivalent unix time for date argument.
        //return int
    }

    public function revertFromUnixTimeStamp($format, $timestamp) {

        //Check timestamp is positive or negative to determine date is before 1970 or after.
        if ($timestamp > 0) {
            //Convert Unix time to your calendar
        } else {
            //Convert Unix time to your calendar
        }

        //Format the result to desired format.
        //Read more here : http://php.net/manual/en/datetime.createfromformat.php
        $date = DateTime::createFromFormat('Y-n-j G:i:s', $date);
        return $date->format($format);
    }

}

?>
