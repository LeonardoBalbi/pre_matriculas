<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiLoginController extends Controller
{
    public function create()
    {
        return view('auth.login-api');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $baseUrl = config('services.api_usuario.base_url');
            $response = Http::post(rtrim($baseUrl, '/').'/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                session([
                    'api_token' => $data['access_token'],
                    'api_user' => $data['user']
                ]);

                return redirect('/inscritos')->with('status', 'Login na API (api_usuario) realizado com sucesso!');
            }

            return back()->withErrors([
                'email' => 'Credenciais inválidas ou erro na API.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Erro de conexão com a API: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function destroy(Request $request)
    {
        // Logout from Project A API (optional but good practice)
        if (session('api_token')) {
            try {
                $baseUrl = config('services.api_usuario.base_url');
                Http::withToken(session('api_token'))->post(rtrim($baseUrl, '/').'/api/logout');
            } catch (\Exception $e) {
                // Ignore errors during logout
            }
        }

        // Clear API session data
        session()->forget(['api_token', 'api_user']);

        // Clear standard Auth if exists
        if (auth()->check()) {
            auth()->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Desconectado com sucesso!');
    }
}
