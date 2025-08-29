<?php

namespace App\Http\Requests\LinkController;

use App\Http\Requests\BaseReq;
use Illuminate\Foundation\Http\FormRequest;

class EditReq  extends BaseReq
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => ['max:2048','url:http,https'],
            'icon' => ['string','max:50','regex:/^([A-Za-z0-9]+(\-[A-Za-z0-9]+)*)$/i'],
            'color' => ['string','between:6,8','regex:/^[A-Za-z0-9]*$/i'],
            'bg_color' => ['string','between:6,8','regex:/^[A-Za-z0-9]*$/i'],
            'status' => ['boolean']
        ];
    }
}
