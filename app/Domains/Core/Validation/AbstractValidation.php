<?php
declare(strict_types=1);

namespace Core\Validation;

use Core\Contracts\Validation\Validation;
use Core\Contracts\Request\Request;
use Core\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidation implements Validation
{
    /**
     * laravelValidator.
     *
     * @var Validator
     */
    protected $laravelValidator;

    /**
     * laravelRequest.
     *
     * @var \Illuminate\Http\Request
     */
    protected $laravelRequest;

    /**
     * validator.
     *
     * @var
     */
    protected $validator;

    /**
     * Rules.
     *
     * @var array;
     */
    protected $rules = [];

    protected $validated;

    /**
     * AbstractValidation constructor.
     *
     * @param Validator                $validator
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Validator $validator, \Illuminate\Http\Request $request)
    {
        $this->laravelValidator = $validator;
        $this->laravelRequest = $request;
    }

    /**
     * validate.
     *
     * @param  Request $request
     * @return bool
     * @throws ValidationException
     */
    public function validate(Request $request): bool
    {
        $this->validator = $this->laravelValidator::make($request->get(), $this->rules);

        if ($this->validator->fails()) {
            throw new ValidationException($this->getErrors());
        }

        return true;
    }

    /**
     * setRules.
     *
     * @param  array $rules
     * @return Validation
     */
    public function setRules(array $rules): Validation
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * getErrors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->validator->errors()->toArray();
    }

    /**
     * getRules.
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * search.
     *
     * @return Validation
     */
    public function search(): Validation
    {
        $this->rules = [
            'query' => 'required'
        ];

        return $this;
    }

    /**
     * search.
     *
     * @return Validation
     */
    public function storeMany(): Validation
    {
        $this->rules = [
            'data' => 'required'
        ];

        return $this;
    }

    /**
     * search.
     *
     * @return Validation
     */
    public function updateMany(): Validation
    {
        $this->rules = [
            'data' => 'required'
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        return $this->validator->validated();
    }

}