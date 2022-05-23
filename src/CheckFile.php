<?php

namespace Faraimunashe\Csv;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckFile
{
    private $result;
    private $delimiter = ',';

    public function __construct()
    {
        $this->result = (object)[
            "extension" => null,
            "headers" => null,
            "error" => null,
            "exception" => null
        ];
    }

    public function extension($path)
    {
        try {
            // Get the file extension
            $extension = pathinfo(storage_path($path), PATHINFO_EXTENSION);

            // File Type Validation
            if (empty($extension)) return $this->result;

            $this->result = (object)[
                "extension" => $extension,
                "exception" => null
            ];
            return (object)$this->result;
        } catch (Exception $e) {
            $this->result = (object)[
                "extension" => null,
                "exception" => $e
            ];
            return (object)$this->result;
        }
    }

    public function headers($path)
    {
        try {
            $extension = pathinfo(storage_path($path), PATHINFO_EXTENSION);
            if (empty($extension) || $extension != "csv") return $this->result;

            $csv = fopen(storage_path($path), 'r');

            $headers = fgetcsv($csv, 0, $this->delimiter);

            return $this->result = (object)[
                "extension" => $extension,
                "headers" => (object)$headers,
                "exception" => null
            ];
        } catch (Exception $e) {
            return $this->result = (object)[
                "extension" => null,
                "headers" => null,
                "exception" => $e
            ];
        }
    }

    public function rows($path)
    {
        $extension = pathinfo(storage_path($path), PATHINFO_EXTENSION);
        if (empty($extension) || $extension != "csv") return $this->result;

        $csv = fopen(storage_path($path), 'r');

        $headers = fgetcsv($csv, 0, $this->delimiter);

        $rows = array();
        $error = array();
        $row_number = 0;
        while ($csv_row = fgetcsv($csv, 0, $this->delimiter)) {

            $row_number++;

            $encoded_row = array_map('utf8_encode', $csv_row);

            if (count($encoded_row) !== count($headers)) {
                return 'Row ' . $row_number . '\'s length does not match the header length: ' . implode(', ', $encoded_row);
            } else {
                if ($encoded_row[0] === "" || $encoded_row[1] === "" || $encoded_row[2] === "" || $encoded_row[3] === "" || $encoded_row[4] === "" || $encoded_row[5] === "" || $encoded_row[6] === "" || $encoded_row[7] === "" || $encoded_row[8] === "" || $encoded_row[9] === "" || $encoded_row[10] === "") {
                    $error[] = array_combine(["message" => "There is a null cell on row: "],  ["row_umber" => $row_number]);
                } else {
                    $rows[] = array_combine($headers, $encoded_row);
                }
            }

            //if( $row_number === 5 ) break;
        }
        if (!empty($error)) {
            return $this->result = (object)[
                "extension" => $extension,
                "headers" => (object)$headers,
                "rows" => null,
                "error" => (object)$error,
                "exception" => null
            ];
        }

        if (!is_null($rows)) {
            return $this->result = (object)[
                "extension" => $extension,
                "headers" => (object)$headers,
                "rows" => $rows,
                "error" => null,
                "exception" => null
            ];
        }
    }

    public function validation(array $rows, array $rules)
    {
        $validator = Validator::make($rows, $rules);

        return $validator;
    }
}
