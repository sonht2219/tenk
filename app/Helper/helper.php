<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 12/31/19
 * Time: 10:50 AM
 */

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

require_once 'restful.php';
//require_once 'constant.php';

if (!function_exists('is_sequential_array')) {
    function is_sequential_array($arr) {
        return is_array($arr) && $arr === array_values($arr);
    }
}

if (!function_exists('filter_data')) {
    function filter_data($data) {
        return array_filter($data, function ($value, $key) {
            return !is_null($value);
        }, ARRAY_FILTER_USE_BOTH);
    }
}

if (!function_exists("get_meta")) {
    /**
     * @param LengthAwarePaginator $paginateData
     * @return array
     */
    function get_meta($paginateData)
    {
        $paginateData->appends(request()->query());

        return [
            'total' => $paginateData->total(),
            'limit' => (int)$paginateData->perPage(),
            'current_page' => $paginateData->currentPage(),
            'last_page' => $paginateData->lastPage(),
            'next_url' => $paginateData->nextPageUrl(),
            'prev_url' => $paginateData->previousPageUrl()
        ];
    }
}

if (!function_exists('parse_number_properties')) {
    /**
     * @param array $data
     * @return array
     */
    function parse_number_properties($data) {
        foreach ($data as $key => $value) {
            if (is_numeric($value)) {
                $data[$key] = $value * 1;
                if (!array_key_exists($key . '_pretty', $data)) {
                    $data[$key . '_pretty'] = number_format($data[$key]);
                }

            }
            if (is_array($value)) {
                $data[$key] = parse_number_properties($value);
            }
        }
        return $data;
    }
}

if (!function_exists("str_slug")) {
    function str_slug($str, $white_space = '-')
    {
        $str = Str::slug($str, $white_space);
        return Str::lower($str);
//        $white_space = $white_space ?: '-';
//        $patterns = [
//            'u' => "/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|U)/",
//            'e' => "/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|é|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|E)/",
//            'o' => "/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|O)/",
//            'a' => "/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|A)/",
//            'i' => "/(ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|I)/",
//            'd' => "/(đ|Đ|D)/",
//            'y' => "/(ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ|Y)/",
//            $white_space => "/[\n\r\s\t]+/",
//            '' => "/[^A-Za-z0-9$white_space]|'$/"
//        ];
//        $str = str_replace(" $white_space ", $white_space, $str);
//        foreach ($patterns as $replacement => $pattern)
//            $str = preg_replace($pattern, $replacement, $str);
//        return strtolower($str);
    }
}

