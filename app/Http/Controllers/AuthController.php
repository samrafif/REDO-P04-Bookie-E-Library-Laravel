<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $role = ($request->publisher) ? "publisher" : "";

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        return redirect()->route('login')->with('status', 'Registration successful!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == "admin") return redirect()->intended('/admin');  
            return redirect()->intended('/');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function index()
    {
        if (!(Auth::user()->role == 'admin')) {
            return redirect()->route('home');
        }

        $allUsers = User::all();
        return view('admin.users', compact('allUsers'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Only allow admin to edit users
        if (Auth::user()->role != 'admin') {
            return redirect()->route('admin.users')->with('error', 'Unauthorized access.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:user,manager,admin',
        ]);

        // Fetch the user
        $user = User::findOrFail($id);

        // Update the user details
        $user->update([
            'name' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Redirect to a relevant page
        return redirect()->route('admin.home')->with('success', 'User updated successfully.');
    }


    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Only allow admin to delete users
        if (Auth::user()->role != 'admin') {
            return redirect()->route('admin.users')->with('error', 'Unauthorized access.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
