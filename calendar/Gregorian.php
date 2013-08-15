<?php

require_once 'BaseCalendar.php';

/**
 * This class will convert Gregorian to unix and vise versa.
 * 
 * @author Farhad Kia
 * @email farhad2161@yahoo.com
 */
class Gregorian extends BaseCalendar {

    /**
     * Covert Gregorian date to Unix time stamp.
     * @param string $format format of date string.
     * @param string $date A date for convert to Unix timestamp.
     * @return int return Unix timestamp.
     */
    public function convertToUnixTimeStamp($format, $date) {
//        if (isset($format)) {
//            $date = DateTime::createFromFormat($format, $date);
//            return strtotime($date->format("Y-m-d H:i:s"));
//        }
//        else
        return strtotime($date);
    }

    /**
     * Revert timestamp to Gregorian date.
     * @param string $format format of returning result.
     * @param string $timestamp Unix timestamp.
     * @return string return date in given format.
     */
    public function revertFromUnixTimeStamp($format, $timestamp) {
        return date($format, $timestamp);
    }

}

?>