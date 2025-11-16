<?php
namespace Core\Contracts\Response;

interface Response
{
    /**
     * setOutputFormat.
     *
     * @param  OutputFormat $outputFormat
     * @return mixed
     */
    public function setOutputFormat(string $outputFormat): Response;

    /**
     * setData.
     *
     * @param  array $data
     * @return mixed
     */
    public function setData(array $data);

    /**
     * data.
     *
     * @return string
     */
    public function data(): string;

    /**
     * setCode.
     *
     * @param int $code
     */
    public function setCode(int $code): void;

    /**
     * code.
     *
     * @return int
     */
    public function code(): int;

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray(): array;

}