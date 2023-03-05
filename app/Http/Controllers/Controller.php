<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    function msgdata($request, $status, $key, $data)
    {
        $msg['status'] = $status;
        $msg['msg'] = $key;
        $msg['data'] = $data;
        return $msg;
    }


    function check_api_token($api_token)
    {
        if ($api_token != null && $api_token != "") {
            return Admin::where("api_token", $api_token)->first();
        } else {
            return null;
        }
    }

    function check_api_token_client($api_token)
    {
        if ($api_token != null && $api_token != "") {
            return Client::where("api_token", $api_token)->first();
        } else {
            return null;
        }
    }

}
