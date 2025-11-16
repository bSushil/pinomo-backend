<?php
declare(strict_types=1);

namespace Core\OutputFormats;

use Core\Contracts\OutputFormat\OutputFormat;

abstract class AbstractOutputFormat implements OutputFormat
{
    protected $formatName;

    protected $formats = [
        'json' => JsonFormat::class
    ];

    /**
     * getOutputFormat.
     *
     * @param  string $outputFormat
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function getOutputFormat(string $outputFormat)
    {
        return app($this->formats[$outputFormat]);
    }
}
