<?php
namespace Core\Contracts\Validation;

use Core\Contracts\Request\Request;

/**
 * Validation
 *
 * Class Validation
 *
 * @package Core\Contracts\Validation
 */
interface Rule
{
    /**
     * validate.
     *
     * @param  $attribute
     * @param  $value
     * @param  $parameters
     * @param  $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator): bool;

    /**
     * message.
     *
     * @param  $message
     * @param  $attribute
     * @param  $rule
     * @param  $parameters
     * @return string
     */
    public function message($message, $attribute, $rule, $parameters): string;

}