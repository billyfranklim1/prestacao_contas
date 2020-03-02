<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PrestacaoContaDetalhe;
use App\Models\PrestacaoConta;
use App\Http\Middleware\Autenticado;

// use App\Http\Middleware\Autenticado;
// use App\Http\Middleware\Autenticado;
// use App\Http\Middleware\Autenticado;
// use App\Http\Middleware\Autenticado;



Route::get('/teste/{id}',function(Request $request){
    // dd($_SERVER['REMOTE_ADDR']);
    return ["stts" => 0, "msg"=>$_SERVER['REMOTE_ADDR']];
});

Route::post('/logar','LoginController@logar');

Route::get('/logout','LoginController@logout');

Route::get('/', function () {if (Auth::check()) {return redirect("/home");}return view('auth.login');})->name('login');



// Route::group(['middleware' => ['Autenticado']], function () {


    Route::get('/estados',function(){
        return DB::select("SELECT * FROM estados");
    });
    Route::get('/categorias',function(){
        return DB::select("SELECT * FROM categoria");
    });


    Route::get('/cidades/{id}',function($id){
        return DB::select("SELECT * FROM cidades WHERE codigo_uf = $id");
    });


    Route::get('/home', function () {return view('index');})->name('home');

    #GRUPO DAS RODAS DE EMPRESAS
    Route::prefix('usuario')->group(function () {

        Route::get('/list/usuario', function () {return view('usuarios.list-usuarios');});
        Route::get('/{id?}','UsuarioController@getUsuario');
        Route::post('/','UsuarioController@cadastrar');
        Route::put('/','UsuarioController@editar');
        Route::get('/ativar/usuario/{id}','UsuarioController@ativarUsuario');
        Route::get('/desativar/usuario/{id}','UsuarioController@desativarUsuario');

    });


    #GRUPO DAS RODAS DE EMPRESAS
    Route::prefix('empresa')->group(function () {

        Route::get('/list/empresa', function () {return view('empresas.list-empresas');});
        Route::get('/{id?}','EmpresaController@getEmpresas');
        Route::post('/','EmpresaController@cadastrar');
        Route::put('/','EmpresaController@editar');
        Route::get('/ativar/empresa/{id}','EmpresaController@ativarEmpresa');
        Route::get('/desativar/empresa/{id}','EmpresaController@desativarEmpresa');

    });

    #GRUPO DAS RODAS DE EMPRESAS
    Route::prefix('filial')->group(function () {

        Route::get('/list/filial', function () {return view('filiais.list-filial');});
        Route::get('/{id?}','FilialController@getFiliais');
        Route::post('/','FilialController@cadastrar');
        Route::put('/','FilialController@editar');
        Route::get('/ativar/filial/{id}','FilialController@ativarFilial');
        Route::get('/desativar/filial/{id}','FilialController@desativarFilial');

    });

    // #GRUPO DAS RODAS DE PRESTACAO CONTAS
    Route::prefix('prestacaoc')->group(function () {

        Route::get('/list/prestacaoc', function () {return view('prestacaoc.list-prestacaoc');});
        Route::get('/{id?}','PrestacaoContaController@getPrestacaoc');
        Route::post('/','PrestacaoContaController@cadastrar');
        Route::put('/','PrestacaoContaController@editar');
        Route::get('/finalizar/prestacaoc/{id}','PrestacaoContaController@finalizarPrestacaoc');
        Route::get('/relatorio/{id}','PrestacaoContaController@baixarRelatorio');

    });

    // #GRUPO DAS RODAS DE PRESTACAO CONTAS
    Route::prefix('dprestacaoc')->group(function () {

        Route::get('/list/dprestacaoc/{id}', function ($id = '') {return view('dprestacaoc.list-dprestacaoc',compact('id'));});
        Route::get('/{id?}','PrestacaoContaDetalheController@getPrestacaoc');
        Route::get('/{id}/byid','PrestacaoContaDetalheController@getPrestacaocByid');
        Route::post('/','PrestacaoContaDetalheController@cadastrar');
        Route::put('/','PrestacaoContaDetalheController@editar');
        Route::get('/finalizar/dprestacaoc/{id}','PrestacaoContaController@finalizarPrestacaoc');
        Route::post('/deletar','PrestacaoContaDetalheController@deletarItem');

    });

// });
