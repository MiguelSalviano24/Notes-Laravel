<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $password = $request->input('text_password');

        $user = User::where('username', $username)->where('deleted_at', NULL)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha inválidos');
        }

        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha inválidos');
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);
        echo 'Login com sucesso';
    }
    public function logout()
    {
        echo "logout";
    }
}
