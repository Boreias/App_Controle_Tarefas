<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Models\Tarefa;
use App\Http\Controllers\Controller;
use App\Mail\NovaTarefaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(5);
        return view('tarefa.index', ['tarefas' => $tarefas]);

        // if(Auth::check())
        // {
        //     $id = Auth::user()->id;
        //     $name = Auth::user()->name;
        //     $email = Auth::user()->email;
        //     return "ID: $id | Nome: $name | Email: $email";
        // }
        // else
        // {
        //     return 'Você não está logado no sistema';
        // }

        // if(auth()->check())
        // {
        //     $id = auth()->user()->id;
        //     $name = auth()->user()->name;
        //     $email = auth()->user()->email;
        //     return "ID: $id | Nome: $name | Email: $email";
        // }
        // else
        // {
        //     return 'Você não está logado no sistema';
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);

        $destinatario = auth()->user()->email; //email do usuário logado (autenticado)

        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($tarefa->user_id == $user_id)
        {
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }
        
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id)
        {
            return view('acesso-negado');
        }

        $tarefa->update($request->all());

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        if(!$tarefa->user_id == auth()->user()->id)
        {
            return view('acesso-negado');
        }

        $tarefa->delete();

        return redirect()->route('tarefa.index');
    }

    public function exportacao(string $extensao)
    {
        $extensoes_validas = ['csv', 'xlsx'];
        if(!in_array($extensao, $extensoes_validas))
        {
            return redirect()->route('tarefa.index');
        }
        
        return Excel::download(new TarefasExport, 'lista_de_tarefas.' . $extensao);
    }
}
