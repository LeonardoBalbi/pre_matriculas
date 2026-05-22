<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiRegisterController extends Controller
{
    public function create()
    {
        return view('auth.register-api');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        try {
            $baseUrl = config('services.api_usuario.base_url');
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post(rtrim($baseUrl, '/').'/api/register', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);

            if ($response->successful()) {
                return redirect('/')->with('status', 'Usuário cadastrado com sucesso no banco api_usuario!');
            }

            $errors = ['email' => 'Erro ao cadastrar na API.'];
            if ($response->json()) {
                $json = $response->json();
                if (isset($json['errors'])) {
                    return back()->withErrors($json['errors'])->withInput();
                } else if (isset($json['message'])) {
                    $errors = ['email' => $json['message']];
                }
            }

            return back()->withErrors($errors)->withInput();

        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erro de conexão: ' . $e->getMessage()])->withInput();
        }
    }
}
