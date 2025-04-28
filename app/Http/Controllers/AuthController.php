<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:8|max:16',
            ],

            [
                'text_username.required' => 'O usuário é obrigatório',
                'text_username.email' => 'O email deve ser válido',
                'text_password.required' => 'A senha é obrigatória',
                'text_password.min' => 'A senha deve ter no mínimo :min caracteres',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres'
            ]

        );

        $username = $request->input('text_username');
        $username = $request->input('text_password');

        try {
            DB::connection()->getPdo();
            echo 'conectou';
        } catch (\PDOException $e) {
            echo 'nao conectou' . $e->getMessage();
        }
    }

    public function logout()
    {
        echo "logout";
    }
}
