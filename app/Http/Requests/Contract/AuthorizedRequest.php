<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 12/31/19
 * Time: 6:22 PM
 */

namespace App\Http\Requests\Contracts;


trait AuthorizedRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !!request()->user();
    }
}
