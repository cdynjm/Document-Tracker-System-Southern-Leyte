<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\LoginRequest;

//CIPHER:
use App\Http\Controllers\AESCipher;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {

        try {
            $request->authenticate();
           
            $aes = new AESCipher;
            $request->session()->regenerate();

            $user = User::where(['id' => Auth::user()->id])->first();
            $authToken = $user->createToken(\Str::random(50))->plainTextToken;
            $request->session()->put('token', $authToken);

            return response()->json([], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'Message' => $e->getMessage(),
            ],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([], Response::HTTP_OK);
    }
}
