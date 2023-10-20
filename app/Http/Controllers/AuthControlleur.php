<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControlleur extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                if (!Auth::user()->isProf && !Auth::user()->isAdmin){
                    return redirect('/index');
                }
            }

            return $next($request);
        });
    }
}
