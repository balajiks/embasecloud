<?php

namespace Modules\Indexing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDruglinksRequest extends FormRequest
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
		   'drugindexterm' => 'required',
        ];
    }
	
	/**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'txtselectedterms.*.custom' => 'Please Select Drug index term field is  required.',
        ];
    }
}
