<?php

namespace Server\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class XlsxImportService
{

    public function import(string $filePath)
    {

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $result = [];
        foreach ($sheet->getRowIterator() as $row) {
            $cells = [];

            foreach ($row->getCellIterator() as $cell) {
                $cells[] = $cell->getValue();
            }

            $result[] = $cells;
            var_dump($result);
            die();
        }


    }
}
