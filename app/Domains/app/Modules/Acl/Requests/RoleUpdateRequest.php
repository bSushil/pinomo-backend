<?php

namespace Main\Modules\Acl\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                Rule::unique('roles', 'name')->where(
                    function ($query) {
                        return $query->whereNull('deleted_at');
                    }
                )->ignore(request()->route('id'))
            ],
        ];
    }
}
