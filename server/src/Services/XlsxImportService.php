<?php

namespace Server\Services;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Server\DTO\ProductDTO;

class XlsxImportService
{
    public function __construct(
        protected ProductService $productService
    ) {}
    public function import(string $filePath)
    {

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $result = [];

        try {
            foreach ($sheet->getRowIterator(2) as $row) {
                $rowIndex = $row->getRowIndex();

                $products = new ProductDTO(
                    externalCode: (string) $sheet->getCell("B$rowIndex")->getValue(),
                    name: (string) $sheet->getCell("E$rowIndex")->getValue(),
                    description: $sheet->getCell("C$rowIndex")->getValue(),
                    price: (float) $sheet->getCell("I$rowIndex")->getValue(),
                    purchasePrice: (float) $sheet->getCell("L$rowIndex")->getValue(),
                );


            $result[$rowIndex] = $products;            }
        } catch (Exception) {
            var_dump('ERROR');
        } finally {
            $spreadsheet->disconnectWorksheets();
        }

        $this->productService->save($result);
    }
}
