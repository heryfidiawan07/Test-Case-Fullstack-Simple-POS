<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

if (!function_exists('can')) {
    function can($action)
    {
        $CI =& get_instance();
        $CI->load->model('AuthModel');
        return $CI->AuthModel->can($action);
    }
}

if (!function_exists('uuid')) {
    function uuid()
    {
        $uuid = Uuid::uuid4();
        return $uuid->toString();
    }
}

?>