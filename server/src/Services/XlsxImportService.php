<?php

namespace Server\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Server\DTO\ProductDTO;
use Server\Entity\ImportJob;
use Server\Repository\ImportJobRepository;
use Throwable;

class XlsxImportService
{
    public function __construct(
        protected ProductService $productService,
        private ImportErrorService $errorService,
        private ImportJobRepository $jobRepository
    ) {}

    public function import(string $filePath, ImportJob $job): void
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

            $directory = dirname(__DIR__, 2) . '/upload/img/'. $job->getId();

            if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
                throw new \RuntimeException('Не удалось создать директорию изображений');
            }

            foreach ($sheet->getRowIterator(2) as $row) {
                $rowIndex = $row->getRowIndex();
                $externalCode = null;

                try {
                    $externalCode = trim(
                        (string) $sheet->getCell("B$rowIndex")->getValue()
                    );

                    if ($externalCode === '') {
                        throw new \InvalidArgumentException('Не указан артикул товара');
                    }

                    $urls = array_filter(
                        array_map(
                            'trim',
                            explode(',', (string) $sheet->getCell("AL$rowIndex")->getValue())
                        )
                    );

                    $image = [];

                    array_map(function ($item) use ($directory, &$image) {
                        $img = file_get_contents($item);

                        if ($img === false) {
                            throw new \RuntimeException(
                                "Не удалось загрузить изображение: {$item}"
                            );
                        }

                        $filename = bin2hex(random_bytes(16)) . '.jpg';
                        $path = $directory . '/' . $filename;

                        if (file_put_contents($path, $img) === false) {
                            throw new \RuntimeException(
                                "Не удалось сохранить изображение: {$item}"
                            );
                        }

                        $image[] = [
                            'url' => $item,
                            'path' => $path
                        ];
                    }, $urls);

                    $product = new ProductDTO(
                        externalCode: $externalCode,
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
                        rowNumber: $rowIndex
                    );

                    $result[$rowIndex] = $product;

                } catch (Throwable $e) {
                    $this->errorService->add(
                        job: $job,
                        row: $rowIndex,
                        externalCode: $externalCode,
                        field: 'row',
                        message: $e->getMessage()
                    );

                    $job->incrementFailed();
                }
            }
        } finally {
            $spreadsheet->disconnectWorksheets();
            $job->setTotalRows(count($result) + $job->getFailedRows());
        }


        if ($result !== []) {
            $this->productService->save($result);

            array_map(
                fn($product) => $job->incrementSuccess(),
                $result
            );
        }

        $job->finish();
        $this->jobRepository->save($job);
    }
}