<?php

namespace App\Http\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

trait SendsPasswordResetEmails
{

    public function showLinkRequestForm(): RedirectResponse
    {
        return new RedirectResponse('https://www.followmyfamily.net/password/reset');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request, Response $response): RedirectResponse
    {
        $this->validateEmail($request);
        $resetLink = $this->broker()->sendResetLink(
            $request->only('email')
        );
        return $resetLink === Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($response);
    }

    protected function validateEmail(Request $request): void
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    protected function sendResetLinkResponse(Response $response): RedirectResponse
    {
        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Response $response): RedirectResponse
    {
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }

    public function broker()
    {
        return Password::broker();
    }
}
