<?php

namespace Faraimunashe\Csv\Classes\Validation;


class IntegerValidation
{
    public $result = false;

    /*
        pass int value as parameter
    */
    public static function validateInt($int)
    {
        if (filter_var($int, FILTER_VALIDATE_INT, )) {
            return true;
        }

        return false;
    }
}
