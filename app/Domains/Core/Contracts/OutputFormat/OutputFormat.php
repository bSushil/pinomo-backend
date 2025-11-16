<?php
namespace Core\Contracts\OutputFormat;

interface OutputFormat
{
    /**
     * output.
     *
     * @param  array $data
     * @return string
     */
    public function output(array $data): string;

    /**
     * getOutputFormat.
     *
     * @param  string $outputFormat
     * @return mixed
     */
    public function getOutputFormat(string $outputFormat);

}