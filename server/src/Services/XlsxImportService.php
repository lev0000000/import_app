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

            $attributeColumns = [];

            foreach ($sheet->getColumnIterator() as $column) {
                $letter = $column->getColumnIndex();

                $header = trim(
                    (string) $sheet->getCell("{$letter}1")->getValue()
                );

                if (str_starts_with($header, 'Доп. поле')) {
                    $key = trim(substr($header, strlen('Доп. поле')));

                    $attributeColumns[$letter] = $key;
                }
            }


            foreach ($sheet->getRowIterator(2) as $row) {
                $rowIndex = $row->getRowIndex();

                $image = [];

                $urls = array_map(
                    'trim',
                    explode(',', (string) $sheet->getCell("AL$rowIndex")->getValue())
                );

                $directory = dirname(__DIR__, 2) . '/upload/img';

                array_map(function ($item) use ($directory, &$image) {

                    $img = file_get_contents($item);
                    $filename = bin2hex(random_bytes(16)) . '.jpg';
                    $path = $directory . '/' . $filename;

                    file_put_contents($path, $img);

                    array_push($image, [
                        'url' => $item,
                        'path' => $path
                    ]);
                }, $urls);



                $products = new ProductDTO(
                    externalCode: (string) $sheet->getCell("B$rowIndex")->getValue(),
                    name: (string) $sheet->getCell("E$rowIndex")->getValue(),
                    description: $sheet->getCell("C$rowIndex")->getValue(),
                    price: (float) $sheet->getCell("I$rowIndex")->getValue(),
                    purchasePrice: (float) $sheet->getCell("L$rowIndex")->getValue(),
                    attributes: array_combine(
                        array_values($attributeColumns),
                        array_map(
                            fn($column) => $sheet->getCell("{$column}{$rowIndex}")->getValue(),
                            array_keys($attributeColumns)
                        )
                    ),
                    images: $image,
                );
                $result[$rowIndex] = $products;
            }
        } finally {
            $spreadsheet->disconnectWorksheets();
        }

        $this->productService->save($result);
    }
}
