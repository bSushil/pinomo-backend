<?php
declare(strict_types=1);

namespace Core\Packages\Media;

use Core\Contracts\Request\Request;
use Core\Packages\Media\Contracts\MediaContract;
use Core\Packages\Media\Contracts\MediaStorage;
use Core\ValueObject\URL;
use Illuminate\Http\UploadedFile;

class MediaPackage implements MediaContract
{
    /**
     * handler.
     *
     * @var
     */
    protected $handler;

    /**
     * storage.
     *
     * @var object
     */
    protected $storage;

    /**
     * MediaPackage constructor.
     *
     * @param MediaStorage $storage
     */
    public function __construct(MediaStorage $storage)
    {
        $this->storage = $storage;
    }


    /**
     * uploadFile.
     *
     * @param  UploadedFile $file
     * @return URL
     */
    public function uploadFile(UploadedFile $file, string $folderName = '', string $fileName = ''): string
    {
        if ($fileName == '') {
            $fileName = md5($file->getClientOriginalName(). time()).'.'.$file->getClientOriginalExtension();
        }
        $fileNameToStore = $fileName;
        if ($folderName != '') {
            $fileNameToStore = $folderName.'/'.$fileName;
        }

        $this->storage->put($fileNameToStore, file_get_contents($file->getRealPath()));
        return $fileName;
    }

    public function fileUrl(string $fileName, string $folderName=''): URL
    {
        $url = '#';
        if ($folderName != '') {
            $url = new Url(asset($this->storage->url($folderName.'/'.$fileName)));
        } else {
            $url = new Url(asset($this->storage->url($fileName)));
        }

        return $url;
    }

    public function deleteFile(string $fileName, string $folderName='')
    {
        if ($folderName != '') {
            $fileName = $folderName.'/'.$fileName;
        }
        $this->storage->delete($fileName);
    }
}
