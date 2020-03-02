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
use App\Models\PrestacaoContaDetalhe;
use DB;




class PrestacaoContaDetalheController extends Controller
{


    public function getPrestacaocByid($id){
        try {

            return PrestacaoContaDetalhe::where('id',$id)->first();

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Ocorreu um erro"];

        }

    }

    public function getPrestacaoc($id = ''){
        try {

            $retorno = [];

            $dados = PrestacaoContaDetalhe::with('hasCategoria')
                ->where('prestacao_conta_id',$id)
                // ->where('status',1)
                ->orderBy('id','desc')
                ->paginate(10);

            $total = "asdasd";

            $retorno['dados'] = $dados;
            $sql =  DB::select("SELECT sum(d.valor) as saldo,
            ( SELECT sum( c.valor ) FROM prestacao_conta_detalhe c WHERE c.prestacao_conta_id = d.prestacao_conta_id and valor > 0 and status = 1) as total_positivo,
            ( SELECT sum( c.valor ) FROM prestacao_conta_detalhe c WHERE c.prestacao_conta_id = d.prestacao_conta_id and valor < 0 and status = 1) as total_negativo
            FROM prestacao_conta_detalhe  d WHERE prestacao_conta_id = $id and status = 1");

            // dd($sql);
            $resumo = [];
            $resumo['receita'] = number_format($sql[0]->total_positivo, 2, ',', '.');
            $resumo['despesa'] = number_format($sql[0]->total_negativo, 2, ',', '.');
            $resumo['saldo']   = number_format($sql[0]->saldo, 2, ',', '.');


            $retorno['resumo'] = $resumo;

            return $retorno;

        } catch (\Exception $e) {
            dd($e);
            return ["stts"=>0,"msg"=>"Ocorreu um erro"];
        }

    }

    public function cadastrar(Request $request){
        try {

            if( $request['documento']){
                $name      = uniqid(date('HisYmd'));
                $extension = $request['documento']->extension();
                $nameFile  = "{$name}.{$extension}";
                $upload    = $request['documento']->storeAs('documentos_prestacao_contas', $nameFile);

                if ( !$upload ){
                    return ["stts"=>0,"msg"=>"Erro ao cadastrar"];
                }
            }

            $nova_dprestacaoc = (array) json_decode($request['nova_dprestacaoc']);

            $prestacaoContas = PrestacaoContaDetalhe::create($nova_dprestacaoc);
            $prestacaoContas->prestacao_conta_id = $request['prestacao_conta_id'];
            $prestacaoContas->arquivo = (empty($nameFile)) ? null : ($nameFile);
            $prestacaoContas->save();


            return ["stts"=>1,"msg"=>"Cadastrado com sucesso"];

        } catch (\Exception $e) {
            dd($e);
            return ["stts"=>0,"msg"=>"Erro ao cadastrar"];

        }

    }

    public function editar(Request $request){

        try {

            PrestacaoContaDetalhe::find($request['edit_dprestacaoc']['id'])->update($request['edit_dprestacaoc']);
            return ["stts"=>1,"msg"=>"Atualizado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao Atualizado"];

        }


    }

    public function finalizarPrestacaoc($id = ''){
        try {
            PrestacaoContaDetalhe::find($id)->update(['status'=>1]);

            return ["stts"=>1,"msg"=>"Ativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao ativar"];

        }
    }

    public function deletarItem(Request $request){
        // dd($id);
        try {

            PrestacaoContaDetalhe::find($request['id'])->update($request->all());

            return ["stts"=>1,"msg"=>"Cancelado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>1,"msg"=>"Erro ao Cancelar"];

        }
    }


}
