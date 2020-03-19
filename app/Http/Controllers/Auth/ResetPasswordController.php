<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

//
//    /**
//     * Where to redirect users after resetting their password.
//     *
//     * @var string
//     */
//    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $tokenData = DB::table('password_resets')
            ->where('created_at', '>=', now()->subHours(1))
            ->where('email', $request->email)
            ->first();

        if ($tokenData && Hash::check($request->get('token'), $tokenData->token)) {
            $user = User::query()
                ->where('email', $request->email)
                ->first();
            $this->resetPassword($user, $request->get('password'));
            $response = Password::PASSWORD_RESET;
        } else {
            return response()->json(['message' => 'Invalid Token'])->setStatusCode(400, 'Invalid Token');
        }

//        $response = $this->broker()->reset(
//            $this->credentials($request), function ($user, $password) {
//            $this->resetPassword($user, $password);
//        }
//        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response === Password::PASSWORD_RESET
            ? response()->json(['message' => Password::PASSWORD_RESET])
            : response()->json(['message' => 'Password reset failed'])->setStatusCode(400, 'Password reset failed');
    }
}
