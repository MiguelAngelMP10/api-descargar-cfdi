<?php

namespace App\Http\Requests;

class DownloadPackagesRequest extends BaseWraperSatWsRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'packagesIds' => ['required', 'array'],
        ]);
    }
}
