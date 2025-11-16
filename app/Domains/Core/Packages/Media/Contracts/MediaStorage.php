<?php
declare(strict_types=1);

namespace Core\Packages\Media\Contracts;

interface MediaStorage
{
    /**
     * Put.
     *
     * @param  string $fileName
     * @param  string $content
     * @return bool
     */
    public function put(string $fileName, string $content): bool;

    /**
     * url.
     *
     * @param  string $fileName
     * @return string
     */
    public function url(string $fileName): string;

    /**
     * Path.
     *
     * @param  string $fileName
     * @return string
     */
    public function path(string $fileName): string;

    /**
     * delete
     *
     * @param string $fileName
     * 
     * @return string
     */
    public function delete(string $fileName): void;
}