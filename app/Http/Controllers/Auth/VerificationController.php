<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user)
    {
        if(! URL::hasValidSignature($request)){
            return response()->json(["errors" => [
                "message" => "URLの有効期限が切れています。"
            ]], 422);
        }

        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "message" => "メールアドレスは既に有効化されています。"
            ]], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message' => 'メールアドレスが有効化されました。'], 200);
    }

    public function resend(Request $request)
    {

    }
}
