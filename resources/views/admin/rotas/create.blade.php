@extends('admin.layouts.master')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">Criar ponto de coleta</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.rotas.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Endereço</label>
                    <input type="text" name="endereco" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Cidade</label>
                    <input type="text" name="cidade" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Estado (UF)</label>
                    <input type="text" name="estado" maxlength="2" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check fa-sm"></i> Salvar
                </button>

                <a href="{{ route('admin.rotas.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
