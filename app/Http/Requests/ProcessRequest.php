<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ProcessRequest class
 * 
 * @author Anitche Chisom <anitchec.dev@gmail.com>
 */
class ProcessRequest extends FormRequest
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
        return [
            'domestic'      => ['required', 'mimes:csv,txt'],
            'foreign'       => ['required', 'mimes:csv,txt'],
            'identifier'    => ['required', 'string'],
            'matcher'       => ['required', 'string'],
            'sum'           => ['nullable']
        ];
    }
}
