<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController
{
    /**
     * Verify the user's email address.
     *
     * @param   \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
