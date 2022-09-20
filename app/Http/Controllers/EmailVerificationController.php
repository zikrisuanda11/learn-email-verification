<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        if($request->user()->hasVerifiedEmail())
        {
            return response()->json([
                'message' => 'email has ready verification'
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'verificatoin email link-send'
        ]);
    }

    public function verify(Request $request)
    {
        if($request->user()->hasVerifiedEmail())
        {
            return response()->json([
                'message' => 'email has ready verification'
            ]);
        }

        if ($request->user()->markEmailAsVerified())
        {
            event(new Verified($request->user()));
        }

        return response()->json(['message' => 'email has ready verified']);
    }
}
