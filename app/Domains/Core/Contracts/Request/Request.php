<?php
declare(strict_types=1);

namespace Core\Contracts\Request;

use Illuminate\Http\Request as RequestURL;

interface Request
{
    /**
     * set.
     *
     * @param array $data
     */
    public function set(array $data, RequestURL $request): void;

    /**
     * get.
     * 
     * @param  string $key
     * @param  string $default
     * @return mixed
     */
    public function get($key = '', $default = '');

    /**
     * getDataForModel.
     *
     * @return array
     */
    public function getDataForModel(): array;

    /**
     * add.
     *
     * @param  string $key
     * @param  $value
     * @return mixed
     */
    public function add(string $key, $value);

    /**
     * Override.
     *
     * @param array $key
     */
    public function override(array $key): void;

    /**
     * Remove.
     *
     * @param string $key
     * @param $value
     */
    public function remove(string $key): void;
}