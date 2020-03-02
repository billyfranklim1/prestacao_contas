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
use App\Models\Usuario;



class UsuarioController extends Controller
{

    public function ativarUsuario($id = ''){
        try {
            Usuario::find($id)->update(['status'=>1]);
            return ["stts"=>1,"msg"=>"Ativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao ativar"];

        }
    }

    public function desativarUsuario($id = ''){
        try {
            Usuario::find($id)->update(['status'=>0]);


            return ["stts"=>1,"msg"=>"Desativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>1,"msg"=>"Erro ao desativar"];


        }
    }
    public function getUsuario($id = ''){
        try {
            if($id){
                return Usuario::where('id',$id)->first();
            }else{
                return Usuario::with('hasEmpresa','hasFilial')->paginate(25);
            }
        } catch (\Exception $e) {
            return ["stts"=>0,"msg"=>"Erro ao buscar !! ","cod"=>$e->getmessage(),"linha"=>$e->getLine()];

        }

    }

    public function cadastar(Requets $request){
        try {

            $usuario          =  Usuario::create($request->all());
            $usuario->senha   =  Hash::make($request['senha']);
            $usuario->save();
            return ["stts"=>1,"msg"=>"Cadastrado com sucesso !!"];
        } catch (\Exception $e) {
            return ["stts"=>0,"msg"=>"Cadastrado com sucesso !!","cod"=>$e->getmessage(),"linha"=>$e->getLine()];
        }

    }


}
