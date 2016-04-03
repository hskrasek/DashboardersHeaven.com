<?php

namespace DashboardersHeaven\Http\Requests;

class PhotoshopRequest extends Request
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
            'title'       => 'sometimes|required',
            'description' => 'required',
            'requestee'   => 'required',
            'sources'     => 'sometimes|required'
        ];
    }
}
