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
use App\Models\PrestacaoConta;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use DateTime;



class PrestacaoContaController extends Controller
{
    public function baixarRelatorio($id = ''){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $id_logado = Auth::user()->id;
        $sql = DB::select("SELECT usuario,u.empresa_id,u.filial_id, e.nome_fantasia as nome_fantasia_empresa, f.nome_fantasia as nome_fantasia_filial FROM usuario u, filial f, empresa e where u.empresa_id = e.id and f.id = u.filial_id and u.id  = $id_logado");
        $metadata = json_decode(json_encode($sql), true);

        // dd($metadata[0]['nome_fantasia_empresa']);

        $cod_empresa = $metadata[0]['empresa_id'];
        $cod_filial  = $metadata[0]['filial_id'];
        $empresa     = $metadata[0]['nome_fantasia_empresa'];
        $filial      = $metadata[0]['nome_fantasia_filial'];
        $usuario     = strtoupper($metadata[0]['usuario']);
        $usuario     = strtoupper($metadata[0]['usuario']);


        $sheet->setCellValue('E3', 'EMPRESA'); $sheet->setCellValue('F3', "$cod_empresa - $empresa");
        $sheet->setCellValue('E4', 'FILIAL');  $sheet->setCellValue('F4', "$cod_filial - $filial");
        $sheet->setCellValue('E5', 'OPERADOR');  $sheet->setCellValue('F5', $usuario);

        $sheet->setCellValue('H3', 'IP CLIENT');  $sheet->setCellValue('I3', $_SERVER['REMOTE_ADDR']);


        $agora = new DateTime(date('Y-m-d H:i:s'));
        $agora  = $agora->format('d/m/Y h:m:s');
        $sheet->setCellValue('H5', 'DATA/HORA GEREÇÃO');  $sheet->setCellValue('I5',$agora );


        $spreadsheet->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);


        $cabecalho = PrestacaoConta::where('id',$id)->first();

        if($cabecalho['status'] == 0){
            $descricao = $cabecalho['descricao'];
            $descricao = "RASCUNHO : $descricao";
        }else{
            $descricao = $cabecalho['descricao'];
            $spreadsheet->getSecurity()->setLockStructure(true);
            $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);
            $spreadsheet->getSecurity()->setWorkbookPassword("laravel");

            $dt_fechamento = new DateTime($cabecalho['fechamento_at']);
            $dt_fechamento  = $dt_fechamento->format('d/m/Y h:m:s');

            $sheet->setCellValue('H4', 'DATA/HORA FECHAMENTO'); $sheet->setCellValue('I4',$dt_fechamento);
            $spreadsheet->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);

        }

        $dt_ini = new DateTime($cabecalho['dt_ini']);
        $dt_fim = new DateTime($cabecalho['dt_fim']);

        $dt_ini = $dt_ini->format('d/m/Y');
        $dt_fim = $dt_fim->format('d/m/Y');

        $nome_arquivo = sprintf("relatoio_de_%s_a_%s",$cabecalho['dt_ini'],$cabecalho['dt_fim']);

        $titulo = "RELATORIO: $descricao - REFERENTE AOS DIAS $dt_ini À $dt_fim";
        $sheet->setCellValue('B1', $titulo);

        $spreadsheet->getActiveSheet()->mergeCells("B1:J1");

        $sql =  DB::select("SELECT sum(d.valor) as saldo,
        ( SELECT sum( c.valor ) FROM prestacao_conta_detalhe c WHERE c.prestacao_conta_id = d.prestacao_conta_id and valor > 0 and status = 1) as total_positivo,
        ( SELECT sum( c.valor ) FROM prestacao_conta_detalhe c WHERE c.prestacao_conta_id = d.prestacao_conta_id and valor < 0 and status = 1) as total_negativo
        FROM prestacao_conta_detalhe  d WHERE prestacao_conta_id = $id and status = 1");

        $receita = number_format($sql[0]->total_positivo, 2, ',', '.');
        $despesa = number_format($sql[0]->total_negativo, 2, ',', '.');
        $saldo   = number_format($sql[0]->saldo, 2, ',', '.');

        $sheet->setCellValue('B3', 'TOTAL DESPESAS'); $sheet->setCellValue('C3', "R$ $despesa");
        $sheet->setCellValue('B4', 'TOTAL RECEITA');  $sheet->setCellValue('C4', "R$ $receita");
        $sheet->setCellValue('B5', 'TOTAL LIQUIDO');  $sheet->setCellValue('C5', "R$ $saldo");


        $spreadsheet->getActiveSheet()->getStyle('B3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
        $spreadsheet->getActiveSheet()->getStyle('B4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3CB371');
        $spreadsheet->getActiveSheet()->getStyle('B5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD700');

        $spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle('B8:F8')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B1:J1')->getFont()->setBold(true);

        // CONCAT('R$ ',valor)  AS	valor
        $arrayData = DB::select("SELECT	descricao,valor,	CASE tipo WHEN 1 THEN 'RECEITA'	WHEN 0 THEN 'DESPESA' END AS tipo,obs,DATE_FORMAT(created_at, '%d/%m/%Y') as data FROM	prestacao_conta_detalhe WHERE prestacao_conta_id = $id and status = 1");
        $arrayData = json_decode(json_encode($arrayData), true);

        $sheet->setCellValue('B8', 'DESCRIÇÃO');
        $sheet->setCellValue('C8', 'VALOR');
        $sheet->setCellValue('D8', 'TIPO');
        $sheet->setCellValue('E8', 'OBSERVAÇÃO');
        $sheet->setCellValue('F8', 'DATA');

        $spreadsheet->getActiveSheet()->fromArray($arrayData,'NULL','B9');

        $qnt = count($arrayData) + 8;
        $spreadsheet->getActiveSheet()
            ->getStyle("C9:C$qnt")
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);




        $writer = new Xlsx($spreadsheet);
        $file = $writer->save("$nome_arquivo.xlsx");
        return response()->download( "$nome_arquivo.xlsx")->deleteFileAfterSend(true);

    }

    public function getPrestacaoc($id = ''){
        try {
            if($id){
                return PrestacaoConta::where('id',$id)->first();
            }else{

                return PrestacaoConta::with('hasUsuario','hasEmpresa','hasFilial')
                    ->where('usuario_id',Auth::user()->id)
                    ->orderBy('nsu','desc')
                    ->paginate(25);
            }
        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Ocorreu um erro"];

        }

    }

    public function cadastrar(Request $request){

        try {

            $ultimaP = PrestacaoConta::where('empresa_id',Auth::user()->empresa_id)
            ->where('filial_id',Auth::user()->filial_id)
            ->orderBy('id','desc')
            ->first();

            $nsu = (empty($ultimaP['nsu'])) ? 1 : ($ultimaP['nsu']+1) ;

            $prestacaoContas = PrestacaoConta::create($request['nova_prestacaoc']);
            $prestacaoContas->usuario_id = Auth::user()->id;
            $prestacaoContas->empresa_id = Auth::user()->empresa_id;
            $prestacaoContas->filial_id  = Auth::user()->filial_id;
            $prestacaoContas->nsu        = $nsu;
            $prestacaoContas->save();



            return ["stts"=>1,"msg"=>"Cadastrado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao cadastrar"];

        }

    }

    public function editar(Request $request){
        try {

            PrestacaoConta::find($request['edit_prestacaoc']['id'])->update($request['edit_prestacaoc']);
            return ["stts"=>1,"msg"=>"Atualizado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao Atualizado"];

        }


    }

    public function finalizarPrestacaoc($id = ''){
        try {
            $prestacao = PrestacaoConta::where('id',$id)->first();
            $prestacao->status        = 1;
            $prestacao->fechamento_at = date('Y-m-d H:i:s');
            $prestacao->save();

            return ["stts"=>1,"msg"=>"Fechado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>0,"msg"=>"Erro ao Fechar"];

        }
    }

    public function desativarPrestacaoConta($id = ''){
        try {

            PrestacaoConta::find($id)->update(['status'=>0]);

            return ["stts"=>1,"msg"=>"Desativado com sucesso"];

        } catch (\Exception $e) {

            return ["stts"=>1,"msg"=>"Erro ao desativar"];


        }
    }


}
