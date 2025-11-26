@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>➕ Novo Produto</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produtos</a></div>
            <div class="breadcrumb-item">Novo</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Informações do Produto</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Nome do Produto *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Descrição *</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="price">Preço (Pontos) *</label>
                                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                                       id="price" name="price" value="{{ old('price') }}" required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stock">Estoque *</label>
                                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                                       id="stock" name="stock" value="{{ old('stock', 1) }}" required>
                                                @error('stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="condition">Condição *</label>
                                                <select class="form-control @error('condition') is-invalid @enderror"
                                                        id="condition" name="condition" required>
                                                    <option value="">Selecione...</option>
                                                    <option value="novo" {{ old('condition') === 'novo' ? 'selected' : '' }}>Novo</option>
                                                    <option value="seminovo" {{ old('condition') === 'seminovo' ? 'selected' : '' }}>Seminovo</option>
                                                    <option value="usado" {{ old('condition') === 'usado' ? 'selected' : '' }}>Usado</option>
                                                </select>
                                                @error('condition')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Categoria</label>
                                                <input type="text" class="form-control @error('category') is-invalid @enderror"
                                                       id="category" name="category" value="{{ old('category') }}"
                                                       placeholder="Ex: Eletrônicos, Periféricos...">
                                                @error('category')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="badge">Badge (Etiqueta)</label>
                                                <input type="text" class="form-control @error('badge') is-invalid @enderror"
                                                       id="badge" name="badge" value="{{ old('badge') }}"
                                                       placeholder="Ex: Novo, Destaque, Promoção">
                                                @error('badge')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status *</label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inativo</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Imagem do Produto</label>
                                        <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                        <small class="form-text text-muted">Tamanho máximo: 2MB</small>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <img id="imagePreview" src="{{ asset('uploads/no-image.png') }}"
                                             alt="Preview" style="width: 100%; border-radius: 8px; border: 1px solid #ddd;">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Salvar Produto
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
