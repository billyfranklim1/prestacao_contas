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
use App\Models\Filial;
use App\Models\Empresa;




class FilialController extends Controller
{

    public function getFiliais($id = ''){
        try {
            if($id){
                return Filial::where('id',$id)->first();
            }else{
                return Filial::with('hasEstado','hasCidade')
                    ->where('empresa_id',Auth::user()->empresa_id)
                    ->paginate(25);
            }
        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Ocorreu um erro"];
        }

    }

    public function cadastrar(Request $request){

        try {

            $nova_filial  = $request['nova_filial'];
            $novo_usuario = $request['novo_usuario'];


            $filial = Filial::create($nova_filial);
            $filial->empresa_id = Auth::user()->empresa_id;
            $filial->save();

            $usuario = new Usuario();
            $usuario->usuario       = $novo_usuario['usuario'];
            $usuario->senha         = Hash::make($request['usuario']['senha']);
            $usuario->empresa_id    = Auth::user()->empresa_id;
            $usuario->filial_id     = $filial['id'];
            $usuario->status        = 0;
            $usuario->save();

            return ["stts"=>1,"msg"=>"Cadastrado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao cadastrar"];

        }

    }

    public function editar(Request $request){
        try {

            Filial::find($request['filial']['id'])->update($request['filial']);
            return ["stts"=>1,"msg"=>"Atualizado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao Atualizado"];

        }


    }

    public function ativarFilial($id = ''){
        try {
            Filial::find($id)->update(['status'=>1]);
            Usuario::where('filial_id',$id)->update(['status'=>1]);


            return ["stts"=>1,"msg"=>"Ativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao ativar"];

        }
    }

    public function desativarFilial($id = ''){

        try {
            Filial::find($id)->update(['status'=>0]);
            Usuario::where('filial_id',$id)->update(['status'=>0]);
            // // dd($usuario);
            // $usuario->status = 0;
            // $usuario->save();

            return ["stts"=>1,"msg"=>"Desativado com sucesso"];

        } catch (\Exception $e) {
            dd($e);
            return ["stts"=>0,"msg"=>"Erro ao desativar"];

        }
    }


}
