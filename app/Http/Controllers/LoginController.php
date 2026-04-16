<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'ds_usuario';
    }

    public function login(Request $request)
    {
        // Validação
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Busca o usuário
        $usuario = Usuario::where('ds_usuario', $request->email)->first();

        // Usuário não encontrado
        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Usuário não encontrado.',
            ])->onlyInput('email');
        }

        // Verifica se o usuário está ativo
        if ($usuario->ie_status !== 'A') {
            return back()->withErrors([
                'email' => 'Usuário inativo. Entre em contato com o administrador.',
            ])->onlyInput('email');
        }

        // Tenta autenticar (apenas se estiver ativo)
        if (Auth::attempt([
            'ds_usuario' => $request->email,
            'password'   => $request->password,
        ], $request->filled('remember'))) {

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Senha incorreta
        return back()->withErrors([
            'email' => 'Usuário ou senha inválidos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
