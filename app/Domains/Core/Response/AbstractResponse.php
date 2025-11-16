<?php
declare(strict_types=1);

namespace Core\Response;

use Core\Contracts\Response\Response;
use Core\Contracts\OutputFormat\OutputFormat;
use Core\OutputFormats\JsonFormat;

abstract class AbstractResponse implements Response
{
    /**
     * Output Format.
     *
     * @var JsonFormat
     */
    protected $chosenOutputFormat;

    /**
     * outputFormat.
     *
     * @var
     */
    protected $outputFormat;

    /**
     * data.
     *
     * @var array
     */
    protected $data;

    /**
     * code.
     *
     * @var int
     */
    protected $code = 200;

    /**
     * AbstractResponse constructor.
     *
     * @param JsonFormat $jsonFormat
     */
    public function __construct(JsonFormat $jsonFormat)
    {
        $this->outputFormat = $jsonFormat;

        $this->chosenOutputFormat = $jsonFormat;
    }

    /**
     * Set Data.
     *
     * @param  array $data
     * @return mixed|void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * appendData.
     *
     * @param $key
     * @param $value
     */
    public function appendData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * setOutputFormat.
     *
     * @param  string $outputFormat
     * @return Response
     */
    public function setOutputFormat(string $outputFormat): Response
    {
        $this->chosenOutputFormat = $this->outputFormat->getOutputFormat($outputFormat);

        return $this;
    }

    /**
     * data.
     *
     * @return string
     */
    public function data(): string
    {
        return $this->chosenOutputFormat->output($this->data);
    }

    /**
     * getData.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * setCode.
     *
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * code.
     *
     * @return int
     */
    public function code(): int
    {
        return $this->code;
    }

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
