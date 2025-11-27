@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>📍 Novo Ponto de Coleta</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.rotas.index') }}">Pontos de Coleta</a></div>
            <div class="breadcrumb-item active">Criar</div>
        </div>
    </div>

    <div class="section-body">

        {{-- CARD DO FORMULÁRIO --}}
        <div class="card">
            <div class="card-header">
                <h4>Adicionar Ponto de Coleta</h4>
            </div>

            <div class="card-body">

                {{-- Exibe erros de validação --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ops! Algo deu errado:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.rotas.store') }}" method="POST" id="rotaForm">
    @csrf
    <div id="methodField"></div>

                    <div class="form-group">
                        <label>Nome do Local</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex.: Galpão Barão 1619" value="{{ old('nome') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Endereço Completo</label>
                        <input type="text" name="endereco" class="form-control" placeholder="Ex.: Av. Barão Homem de Melo, 1619" value="{{ old('endereco') }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Cidade</label>
                            <input type="text" name="cidade" class="form-control" placeholder="Ex.: Belo Horizonte" value="{{ old('cidade') }}" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>UF</label>
                            <input type="text" name="estado" class="form-control" maxlength="2" placeholder="MG" value="{{ old('estado') }}" required>
                        </div>
                    </div>

                  <button class="btn btn-primary mt-3" id="submitButton">
    <i class="fas fa-save fa-sm"></i> Salvar Ponto
</button>
                </form>
            </div>
        </div>

        {{-- CARD DA LISTA DE PONTOS JA CRIADOS --}}
        <div class="card mt-4">
            <div class="card-header">
                <h4>Pontos de Coleta Criados</h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>UF</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($rotas as $rota)
                                <tr>
                                    <td>{{ $rota->nome }}</td>
                                    <td>{{ $rota->endereco }}</td>
                                    <td>{{ $rota->cidade }}</td>
                                    <td>{{ $rota->estado }}</td>

                                    <td>
                                        {{-- EDITAR (AINDA NÃO CRIADO) --}}
                                <button type="button"
        class="btn btn-sm btn-secondary btn-edit"
        data-id="{{ $rota->id }}"
        data-nome="{{ $rota->nome }}"
        data-endereco="{{ $rota->endereco }}"
        data-cidade="{{ $rota->cidade }}"
        data-estado="{{ $rota->estado }}">
    <i class="fas fa-edit"></i>
</button>

                                        {{-- EXCLUIR --}}
                        <form action="{{ route('admin.rotas.destroy', $rota->id) }}" method="POST" class="d-inline">
                           @csrf
                            @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                         <i class="fas fa-trash fa-sm"></i>
                                             </button>
                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        Nenhum ponto cadastrado até agora.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("rotaForm");
    const methodField = document.getElementById("methodField");

    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function () {

            const id = this.dataset.id;

            // Preenche os inputs
            document.querySelector("input[name='nome']").value = this.dataset.nome;
            document.querySelector("input[name='endereco']").value = this.dataset.endereco;
            document.querySelector("input[name='cidade']").value = this.dataset.cidade;
            document.querySelector("input[name='estado']").value = this.dataset.estado;

            // Troca a rota do formulário para UPDATE
            form.action = `/admin/rotas/${id}`;

            // Adiciona o método PUT
            methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;

            // Troca o botão
            document.getElementById("submitButton").innerHTML = `
                <i class="fas fa-save fa-sm"></i> Atualizar
            `;
        });
    });
});
</script>
@endsection
