@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Atualizar tarefa</div>

                <div class="card-body">
                    <form method="post" action="{{ route('tarefa.update', ['tarefa' => $tarefa->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          <label for="inputTarefa">Tarefa</label>
                          <input type="text" name="tarefa" class="form-control" id="inputTarefa" placeholder="Informe a tarefa" value="{{ $tarefa->tarefa }}">
                        </div>
                        <div class="form-group">
                          <label for="inputDataLimiteConclusao">Data limite conclusão</label>
                          <input type="date" name="data_limite_conclusao" class="form-control" id="inputDataLimiteConclusao" placeholder="Data limite" value="{{ $tarefa->data_limite_conclusao }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
