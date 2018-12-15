<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function emailVerifyNotice(Request $request)
    {
        return view('pages.email_verify_notice');
    }
    public function root()
    {
        return view('welcome');
    }
}
