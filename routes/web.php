<?php

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');
route::view('/teste', 'tela-teste');

route::view('/cadastro', 'tela-cadastro')->name('telaCadastro');
route::view('/login', 'login')->name('login');

route::get('/logout',
     function(Request $request){
            Auth::logout();
            $request->session()->regenerate();
            return redirect()->route('home');
     }

)->name('logout');





route::post( '/salva-usuario', 
    function(Request $request){
        $user = new User();
        $user->name =$request->nome;
        $user->email =$request->email;
        $user->password =$request->senha;
        $user->save();

        return redirect()->route('home');
    }
)
->name('SalvaUsuario');
 route::post('logar', 
    function(Request $request) 
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
     
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
     
                return redirect()->intended('/');
            }
     
            return back()->withErrors([
                'email' => 'email ou senha invalidos.',
            ])->onlyInput('email');
         }
)->name('logar');


Route::get('/gerencia-noticias',
function(){

    $noticias = Noticia::all();
    return view('gerencia-noticias', compact('noticias'));
}

)->name('gerenciaNoticias');