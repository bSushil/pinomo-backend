<?php
declare(strict_types=1);

namespace Core\Packages\Media\Storage;

use Core\Packages\Media\Contracts\MediaStorage;
use Illuminate\Support\Facades\Storage;

class LaravelStorage implements MediaStorage
{

    /**
     * Put.
     *
     * @param  string $fileName
     * @param  string $content
     * @return bool
     */
    public function put(string $fileName, string $content): bool
    {
        return Storage::put($fileName, $content);
    }

    /**
     * url.
     *
     * @param  string $fileName
     * @return string
     */
    public function url(string $fileName): string
    {
        return asset(Storage::url($fileName));
    }

    /**
     * Path.
     *
     * @param  string $fileName
     * @return string
     */
    public function path(string $fileName): string
    {
        $filePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix(). $fileName;
        return $filePath;
    }

    public function delete(string $fileName): void
    {
        Storage::delete($fileName);
    }
}