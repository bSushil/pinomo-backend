<?php
namespace Main\Services;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

/**
 * ChunkReadFilter
 */
class ChunkReadFilter implements IReadFilter
{
    private int $_startRow = 0;
    private int $_endRow   = 0;

    /**
     * Set the list of rows that we want to read  
     */    
    /**
     * setRows
     *
     * @param  int $startRow
     * @param  int $chunkSize
     * @return void
     */
    public function setRows(int $startRow, int $chunkSize)
    {
        $this->_startRow = $startRow;
        $this->_endRow   = $startRow + $chunkSize;
    }
    
    /**
     * readCell
     *
     * @param  int    $columnAddress
     * @param  int    $row
     * @param  string $worksheetName
     * @return bool
     */
    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        //  Only read the heading row, and the configured rows
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
            return true;
        }
        return false;
    }
}