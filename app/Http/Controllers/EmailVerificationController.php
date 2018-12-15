<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;
use App\Notifications\EmailVerificationNotification;
use Mail;
use App\Exceptions\InvalidRequestException;

class EmailVerificationController extends Controller
{
    //
    public function verify(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        if (!$email || !$token) throw new InvalidRequestException('驗證連結錯誤');
        if ($token != Cache::get('email_verification_'.$email)) throw new InvalidRequestException('驗證連結超時');
        if (!$user = User::where('email', $email)->first()) throw new InvalidRequestException('使用者不存在');
        Cache::forget('email_verification_'.$email);
        $user->update(['email_verified' => true]);
        return view('pages.success', ['msg' => '信箱驗證成功']);
    }
    public function send(Request $request)
    {
        $user = $request->user();
        if ($user->email_verified) throw new InvalidRequestException('您已驗證過信箱');
        $user->notify(new EmailVerificationNotification());
        return view('pages.success', ['msg' => '驗證信發送成功']);
    }
}
