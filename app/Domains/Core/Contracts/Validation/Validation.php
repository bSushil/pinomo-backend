<?php
namespace Core\Contracts\Validation;

use Core\Contracts\Request\Request;

use Illuminate\Http\JsonResponse;

/**
 * Validation
 *
 * Class Validation
 *
 * @package Core\Contracts\Validation
 */
interface Validation
{
    /**
     * validate.
     *
     * @param  Request $request
     * @param  array   $roles
     * @return bool
     */
    public function validate(Request $request): bool|JsonResponse;

    /**
     * getErrors.
     *
     * @return array
     */
    public function getErrors(): array;

    /**
     * setRoles.
     *
     * @param  array $roles
     * @return Validation
     */
    public function setRules(array $roles): Validation;

    /**
     * Store.
     *
     * @return Validation
     */
    public function store(): Validation;

    /**
     * Update.
     *
     * @return Validation
     */
    public function update(): Validation;

    /**
     * Update.
     *
     * @return Validation
     */
    public function updateMany(): Validation;

    /**
     * Search.
     *
     * @return Validation
     */
    public function search(): Validation;
}