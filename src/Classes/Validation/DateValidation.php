<?php

namespace Faraimunashe\Csv\Classes\Validation;

use DateTime;
use Carbon\Carbon;

class DateValidation
{
    public $result = false;

    /*
        pass date value as first parameter
        pass date format as second parameter
    */
    public static function validateDate($date, $format = 'd/m/Y')
    {
        $d = Carbon::createFromFormat($format, $date);
        return $d === date($format, strtotime($d));
        // $d = DateTime::createFromFormat($format, $date);
        // return $d && $d->format($format) === $date;
    }
}
