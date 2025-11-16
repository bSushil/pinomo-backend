<?php
namespace Main\Traits;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

trait CsvFileTrait
{
    /**
     * _fileReader
     *
     * @param  string $file
     * @return \PhpOffice\PhpSpreadsheet\Reader\IReader
     */
    public function fileReader(string $file)
    {
        $fileType = IOFactory::identify($file);
        return IOFactory::createReader($fileType);        
    }
    
    /**
     * _sanitizeSpreadsheetData
     *
     * @param  array $arSpreadsheetData
     * @return array
     */
    public function sanitizeSpreadsheetData(array $arSpreadsheetData): array
    {
        $arData = array_filter($arSpreadsheetData, [$this, '_filterArrayElement']);
        return $arData;
    }
    
    /**
     * fileWriter
     *
     * @param  string $file
     * @return IWriter
     */
    public function fileWriter(string $file): IWriter
    {
        $fileType = IOFactory::identify($file);
        $reader = IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($file);
        return IOFactory::createWriter($spreadsheet, $fileType);        
    }

    /**
     * _filterArrayElement
     *
     * @param  mixed $item
     * @return bool
     */
    private function _filterArrayElement($item): bool
    {
        return ($item[0] !== null);
    }
    
    /**
     * getTotalLines
     *
     * @param  mixed $filePath
     * @return int
     */
    public function getTotalLines(string $filePath): int
    {
        $totalLines = 0;
        $fileType = IOFactory::identify($filePath);
        $reader = IOFactory::createReader($fileType);

        $worksheetData = $reader->listWorksheetInfo($filePath);
        foreach ($worksheetData as $worksheet) {
            $totalLines = $worksheet['totalRows'];
            break;
        }

        return $totalLines;
    }
}