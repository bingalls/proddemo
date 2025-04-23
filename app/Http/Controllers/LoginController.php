<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function loginPage(): Factory|View|Application
    {
        return view('login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->validated();
        if (Auth::attempt($request->safe()->only('email', 'password'))) {
            return redirect()->route('admin.products');
        }

        return redirect()
            ->back()
            ->with('error', 'Invalid login credentials')
            ->withInput();
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login');
    }

}
