<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 1/1/20
 * Time: 11:26 AM
 */

namespace App\Http\Controllers;


trait AuthorizedController
{
    protected function user() {
        return request()->user();
    }
}
