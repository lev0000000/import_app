<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Server\DTO\ProductDTO;
use Server\Entity\ImportJob;
use Server\Repository\ImportJobRepository;
use Server\Services\ImportErrorService;
use Server\Services\ProductService;
use Server\Services\XlsxImportService;

final class XlsxImportServiceTest extends TestCase
{
    private string $filePath;

    protected function setUp(): void
    {
        $this->filePath = tempnam(sys_get_temp_dir(), 'xlsx_');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('B1', 'Артикул');
        $sheet->setCellValue('E1', 'Название');
        $sheet->setCellValue('I1', 'Цена');
        $sheet->setCellValue('L1', 'Закупочная цена');

        $sheet->setCellValue('B2', 'TEST-001');
        $sheet->setCellValue('E2', 'Тестовый шкаф');
        $sheet->setCellValue('I2', 15000);
        $sheet->setCellValue('L2', 10000);

        $writer = new Xlsx($spreadsheet);
        $writer->save($this->filePath);

        $spreadsheet->disconnectWorksheets();
    }

    protected function tearDown(): void
    {
        if (is_file($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function testImportValidProduct(): void
    {
        $productService = $this->createMock(ProductService::class);
        $errorService = $this->createMock(ImportErrorService::class);
        $jobRepository = $this->createMock(ImportJobRepository::class);
        $job = $this->createMock(ImportJob::class);

        $job->method('getId')->willReturn('123');

        $productService
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function (array $products): bool {
                $product = $products[2] ?? null;

                return $product instanceof ProductDTO
                    && $product->externalCode === 'TEST-001'
                    && $product->name === 'Тестовый шкаф'
                    && $product->price === 15000.0;
            }));

        $errorService
            ->expects($this->never())
            ->method('add');

        $job->expects($this->once())->method('incrementSuccess');
        $job->expects($this->never())->method('incrementFailed');
        $job->expects($this->once())->method('finish');

        $jobRepository
            ->expects($this->once())
            ->method('save')
            ->with($job);

        $service = new XlsxImportService(
            $productService,
            $errorService,
            $jobRepository
        );

        $service->import($this->filePath, $job);
    }

    public function testImportWithoutExternalCode(): void
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('B1', 'Артикул');
        $sheet->setCellValue('E1', 'Название');
        $sheet->setCellValue('E2', 'Товар без артикула');

        (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet))
            ->save($this->filePath);

        $spreadsheet->disconnectWorksheets();

        $productService = $this->createMock(ProductService::class);
        $errorService = $this->createMock(ImportErrorService::class);
        $jobRepository = $this->createMock(ImportJobRepository::class);
        $job = $this->createMock(ImportJob::class);

        $job->method('getId')->willReturn('123');

        $productService
            ->expects($this->never())
            ->method('save');

        $errorService
            ->expects($this->once())
            ->method('add')
            ->with(
                job: $job,
                row: 2,
                externalCode: null,
                field: 'row',
                message: 'Не указан артикул товара'
            );

        $job
            ->expects($this->once())
            ->method('incrementFailed');

        $job
            ->expects($this->once())
            ->method('finish');

        $jobRepository
            ->expects($this->once())
            ->method('save')
            ->with($job);

        $service = new XlsxImportService(
            $productService,
            $errorService,
            $jobRepository
        );

        $service->import($this->filePath, $job);
    }
}
