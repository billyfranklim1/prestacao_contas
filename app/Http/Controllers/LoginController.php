<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use AuthenticatesAndRegistersUsers, ThrottlesLogins;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Filial;
use App\Models\Empresa;
use App\Models\Usuario;





class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function logar(Request $request){

        try {
            $r_usuario = $request['usuario'];
            $r_senha   = $request['senha'];

            $usuario = Usuario::where('usuario',$r_usuario)->first();

            // dd($usuario);
            if(Hash::check($r_senha, $usuario['senha'])){
                if($usuario->status == 0){
                    return ["stts"=>0,"msg"=>"Usuario Inativo"];
                }

                $empresa = $usuario['empresa_id'];
                $filial  = $usuario['filial_id'];

                if($usuario['senha'] == 'admin'){
                    session(['tipo' => 0]);
                }else if($filial == 0){
                    // GERENTE DA EMPRESA
                    session(['tipo' => 1]);
                }else{
                    // FILIAL
                    session(['tipo' => 2]);
                }

                Auth::loginUsingId($usuario['id']);
                return ["stts"=>1,"msg"=>"Credenciais corretas"];
            }else{

                return ["stts"=>0,"msg"=>"Credenciais incorretas"];
            }


        } catch (\Exception $e) {
            // dd($e);
            return ["stts"=>0,"msg"=>"Ocorreu um Erro","cod"=>$e->getmessage()];

        }
    }

    public function logout(Request $request){

        $request->session()->flush();
        $request->session()->regenerate();
        Auth::logout();
        $request->session()->flush();
        return redirect('/');
    }


}
