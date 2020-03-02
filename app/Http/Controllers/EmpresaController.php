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
use App\Models\Empresa;



class EmpresaController extends Controller
{
    public function getEmpresas($id = ''){
        try {
            if($id){
                return Empresa::where('id',$id)->first();
            }else{
                return Empresa::with('hasEstado','hasCidade')->paginate(25);
            }
        } catch (\Exception $e) {

        }

    }

    public function cadastrar(Request $request){

        try {

            $nova_empresa = $request['nova_empresa'];
            $novo_usuario = $request['novo_usuario'];



            $empresa = Empresa::create($nova_empresa);

            $usuario = new Usuario();
            $usuario->usuario       = $novo_usuario['usuario'];
            $usuario->senha         = Hash::make($novo_usuario['senha']);
            $usuario->empresa_id    = $empresa['id'];
            $usuario->filial_id     = 0;
            $usuario->status        = 0;
            $usuario->save();

            return ["stts"=>1,"msg"=>"Cadastrado com sucesso"];

        } catch (\Exception $e) {
            // dd($e);
            return ["stts"=>0,"msg"=>"Erro ao cadastrar"];

        }

    }

    public function editar(Request $request){
        try {

            Empresa::find($request['empresa']['id'])->update($request['empresa']);
            return ["stts"=>1,"msg"=>"Atualizado com sucesso"];


        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao Atualizado"];

        }


    }

    public function ativarEmpresa($id = ''){
        try {
            Empresa::find($id)->update(['status'=>1]);
            Usuario::where('empresa_id',$id)->update(['status'=>1]);
            return ["stts"=>1,"msg"=>"Ativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao ativar"];

        }
    }

    public function desativarEmpresa($id = ''){
        try {
            Empresa::find($id)->update(['status'=>0]);
            Usuario::where('empresa_id',$id)->update(['status'=>0]);


            return ["stts"=>1,"msg"=>"Desativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>1,"msg"=>"Erro ao desativar"];


        }
    }


}
