<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait CommonTrait {

    static function session_id()
    {
        if (Session::has('session_id')) {
            $session_id = Session::get('session_id');
        }
        else{
            $session_id = Str::random(36);
            Session::put('session_id', $session_id);
        }

        return $session_id;
    }
}