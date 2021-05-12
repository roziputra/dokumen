<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Penilaian;
use Illuminate\Validation\Rule;

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

        if ($route->named('penilaian.item.add')) {
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

        if ($route->named('penilaian.status.update')) {
            return [
                'kelengkapan' => [
                    'required',
                    'string',
                    Rule::in(array_keys(Penilaian::getAllKelengkapan())),
                ],
                'tingkat_kelengkapan' => [
                    'nullable',
                    'string',
                    Rule::in(array_keys(Penilaian::getAllTingkatKelengkapan())),
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
