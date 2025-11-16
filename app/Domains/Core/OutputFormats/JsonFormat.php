<?php
declare(strict_types=1);

namespace Core\OutputFormats;

use Core\OutputFormats\AbstractOutputFormat;

class JsonFormat extends AbstractOutputFormat
{
    public function output(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}