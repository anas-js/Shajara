<?php

namespace App\Http\Requests\LinkController;

use App\Http\Requests\BaseReq;
use Illuminate\Foundation\Http\FormRequest;

class CreateReq extends BaseReq
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => ['required','max:2048','url:http,https'],
            'icon' => ['required','string','max:50','regex:/^([A-Za-z0-9]+(\-[A-Za-z0-9]+)*)$/i'],
            'color' => ['required','string','between:6,8','regex:/^[A-Za-z0-9]*$/i'],
            'bg_color' => ['required','string','between:6,8','regex:/^[A-Za-z0-9]*$/i'],
            'status' => ['required','boolean']
        ];
    }


}
