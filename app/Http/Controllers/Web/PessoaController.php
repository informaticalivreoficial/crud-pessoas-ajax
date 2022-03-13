<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pais;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use DataTables;

class PessoaController extends Controller
{
    public function index(Request $request)
    {
        $pessoas = Pessoa::latest()->get();
        $paises = Pais::orderBy('created_at', 'DESC')->get();

        if ($request->ajax()) {
            $data = Pessoa::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPessoa">Editar</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePessoa">Excluir</a>';
    
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('web.pessoas',[
            'pessoas' => $pessoas,
            'paises' => $paises
        ]);
    }

    public function store(Request $request)
    {
        Pessoa::updateOrCreate([
                'id' => $request->pessoa_id
            ],
                [
                    'nome' => $request->nome, 
                    'genero' => $request->genero, 
                    'nascimento' => $request->nascimento, 
                    'pais_id' => $request->pais_id
                ]);        
   
        return response()->json(['success'=>'Pessoa cadastrada com sucesso!']);
    }

    public function edit($id)
    {
        $pessoa = Pessoa::find($id);
        return response()->json($pessoa);
    }

    public function destroy($id)
    {
        Pessoa::find($id)->delete();
     
        return response()->json(['success'=>'Cadastro removido!']);
    }
}