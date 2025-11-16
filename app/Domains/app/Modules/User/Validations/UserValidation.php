<?php

namespace Main\Modules\User\Validations;

use Illuminate\Validation\Rule;

use Core\Validation\AbstractValidation;
use Core\Contracts\Validation\Validation;
use Illuminate\Validation\Rules\Password;

class UserValidation extends AbstractValidation
{
    public function store(): Validation
    {
        $this->rules = [
            'name' => 'string|required',
            'email' => 'email|required||unique:Main\Modules\User\Models\User,email',
            'password' => ['string','required', Password::min(8)]
        ];

        return $this;
    }

    public function update(): Validation
    {
        $this->rules = [
            'name' => 'string|required',
        ];
        
        return $this;
    }

    public function changePassword():Validation
    {
        $this->rules = [
            'password' => ['string','required', 'confirmed', Password::min(8)]
        ];
        return $this;
    }
}