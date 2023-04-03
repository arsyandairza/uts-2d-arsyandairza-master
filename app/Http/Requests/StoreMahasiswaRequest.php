<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
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
            'nim' => 'required|numeric|unique:mahasiswa,nim|max:10',
            'nama' => 'required',
            'jurusan' => 'required',
            'email' => 'required|max:12',
            'nomor_handphone' => 'required|numeric|max:10',
            'alamat' => 'required',
        ];
    }
}
