<?php

namespace Main\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Main\Modules\User\Models\User;

class UserUpdateRequest extends FormRequest
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
            //
            'name' => 'string|required',
            'email' => [
                'email',
                'required',
                Rule::unique(User::class, 'email')->ignore($this->id),
            ],
            // 'password' => [
            //     'string',
            //     'nullable',
            //     Password::min(8)
            // ],
            'role_id' => 'integer|required|exists:Main\Modules\Acl\Models\Role,id',
        ];
    }
}
