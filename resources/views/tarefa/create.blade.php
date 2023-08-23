@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Adicionar tarefa</div>

                <div class="card-body">
                    <form method="post" action="{{ route('tarefa.store') }}">
                        @csrf
                        <div class="form-group">
                          <label for="inputTarefa">Tarefa</label>
                          <input type="text" name="tarefa" class="form-control" id="inputTarefa" placeholder="Informe a tarefa">
                        </div>
                        <div class="form-group">
                          <label for="inputDataLimiteConclusao">Data limite conclusão</label>
                          <input type="date" name="data_limite_conclusao" class="form-control" id="inputDataLimiteConclusao" placeholder="Data limite">
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
