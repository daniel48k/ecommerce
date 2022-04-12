<?php

namespace App\Http\Controllers\Auth;

use App\Constants\RoleConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /**@var UserRepository */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        return view('frontend.pages.login');
    }


    public function register()
    {
        return view('frontend.pages.register');
    }

    public function registerSubmit(UserRegistrationRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRepository->create($data);
        Session::put('user', $data['email']);

        if ($user) {
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('login.form');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }

    public function authenticate(UserLoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully login');
            if (auth()->user()->role == RoleConstants::ADMIN)
                return redirect()->route('admin');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid Credentials, try again!');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');
        return back();
    }
}
