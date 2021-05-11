<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianForm extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $route = $this->route();

        if ($route->named('penilaian.item.*')) {
            return [
                'grup_penilaian' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'sub_grup_penilaian' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'judul_penilaian' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ];
        }

        return [
            'nama_unit_kerja' => [
                'required',
                'string',
                'max:255',
            ],
            'petugas_pendampingan' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
