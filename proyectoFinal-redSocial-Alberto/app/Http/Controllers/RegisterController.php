<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
        public function index () {
            return view('auth.register');
        }

        public function store (Request $request) {

            $request->request->add(['username' => Str::slug($request->username)]);    

            $validated = $request->validate([
                'name' => 'required|max:30',
                'username' => 'required|unique:users|min:3|max:20',
                'email' => 'required|unique:users|email|max:60',
                'password' => 'required|confirmed|min:6'
            ]);

            User::create([
                'name' => $validated['name'],      
                'username' => Str::slug ($validated['username']),
                'email' => $validated['email'],   
                'password' => bcrypt($validated['password']),
                'role' => 'user',
            ]);

            Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password']
            ]);

            return redirect()->route('posts.index', auth()->user());
        }
}
