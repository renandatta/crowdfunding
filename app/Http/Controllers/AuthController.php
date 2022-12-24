<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function login_process(LoginRequest $request)
    {
        $remember = $request->has('remember');
        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            return redirect()->route('/');
        }
        return redirect()->route('login')
            ->with('error', 'Email atau Password Salah !');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_process(RegisterRequest $request)
    {
        $request->merge(['user_level' => 'user']);
        $user = $this->userRepository->store($request);
        Auth::login($user);

        return redirect()->route('/');
    }
}
