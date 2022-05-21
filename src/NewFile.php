<?php

namespace Faraimunashe\Csv;

use Exception;
use Illuminate\Http\Request;

class NewFile
{
    private $result;

    public function __construct()
    {
        $this->result = (object)[
            "saved" => false
        ];
    }

    public function add(Request $file)
    {
        try {
            $fileName = time() . '.' . $file->file->extension();

            $file->file->move(storage_path('uploads'), $fileName);
            $this->result = [
                "fileName" => $fileName,
                "saved" => true,
                "message" => "success"
            ];

            return $this;
        } catch (Exception $e) {
            $this->result = [
                "fileName" => null,
                "saved" => false,
                "message" => $e->getMessage()
            ];
            return $this;
        }
    }

    public function getResult()
    {
        return (object)$this->result;
    }
}
