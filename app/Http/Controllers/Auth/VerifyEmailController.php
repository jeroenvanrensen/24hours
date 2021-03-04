<?php

namespace App\Http\Controllers\Auth;

use App\Mail\WelcomeEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController
{
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        Mail::to(auth()->user()->email)->queue(new WelcomeEmail(auth()->user()));

        return redirect()->to(route('invitations.check'));
    }
}
