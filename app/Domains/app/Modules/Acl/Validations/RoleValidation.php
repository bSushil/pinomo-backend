<?php
namespace Main\Modules\Acl\Validations;

use Core\Contracts\Validation\Validation;
use Core\Validation\AbstractValidation;

/**
 * RoleValidation
 */
class RoleValidation extends AbstractValidation
{
    
    /**
     * store
     *
     * @return Validation
     */
    public function store(): Validation
    {
        $this->rules = [];
        return $this;
    }
    
    /**
     * update
     *
     * @return Validation
     */
    public function update(): Validation
    {
        $this->rules = [];
        return $this;
    }
}