<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;
class AuthController extends Controller
{
    public function login()
    {
        $assets = Asset::where('is_active', true)->get();
        if(Auth::check()) {
            return redirect()->route('home');
        }
        return view('pages.landing.auth.login', compact('assets'));
    }

    public function register()
    {
        if(Auth::check()) {
            return redirect()->route('home');
        }
        $assets = Asset::where('is_active', true)->get();
        return view('pages.landing.auth.register', compact('assets'));
    }
}
