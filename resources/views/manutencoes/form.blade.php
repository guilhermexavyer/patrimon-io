@extends('layouts.app')

@section('title', isset($manutencao) ? 'Editar manutenção' : 'Cadastrar manutenção')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho -->
    <div class="usuarios-header">
        <h2>{{ isset($manutencao) ? 'Editar manutenção' : 'Cadastrar manutenção' }}</h2>
    </div>

    <!-- Mensagens -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($manutencao) ? route('manutencoes.update', $manutencao->nr_sequencia) : route('manutencoes.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($manutencao))
                @method('PUT')
            @endif

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text"
                               id="nr_sequencia"
                               name="nr_sequencia"
                               class="input-desabled form-control"
                               value="{{ old('nr_sequencia', $manutencao->nr_sequencia ?? '') }}"
                               disabled>
                    </div>

                    <div class="form-group half">
                        <label for="ie_tipo">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Tipo
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: ie_tipo"></i>
                        </label>
                        <select id="ie_tipo"
                                name="ie_tipo"
                                class="form-control @error('ie_tipo') is-invalid @enderror"
                                required>
                            <option value="">---</option>
                            <option value="C" {{ old('ie_tipo', $manutencao->ie_tipo ?? '') == 'C' ? 'selected' : '' }}>Corretiva</option>
                            <option value="P" {{ old('ie_tipo', $manutencao->ie_tipo ?? '') == 'P' ? 'selected' : '' }}>Preventiva</option>
                        </select>
                        @error('ie_tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_descricao">
                        <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                        Descrição
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: ds_descricao"></i>
                    </label>
                    <input type="text"
                           id="ds_descricao"
                           name="ds_descricao"
                           class="form-control @error('ds_descricao') is-invalid @enderror"
                           value="{{ old('ds_descricao', $manutencao->ds_descricao ?? '') }}"
                           required>
                    @error('ds_descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_seq_ativo">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Ativo
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: nr_seq_ativo"></i>
                        </label>
                        <select id="nr_seq_ativo"
                            name="nr_seq_ativo"
                            class="form-control @error('nr_seq_ativo') is-invalid @enderror"
                            required>
                        <option value="">---</option>
                        @foreach($ativos as $ativo)
                            <option value="{{ $ativo->nr_sequencia }}"
                                {{ old('nr_seq_ativo', $ativoSelecionado ?? ($manutencao->nr_seq_ativo ?? '')) == $ativo->nr_sequencia ? 'selected' : '' }}>
                                {{ $ativo->ds_nome }}
                            </option>
                        @endforeach
                        </select>
                        @error('nr_seq_ativo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_seq_prestador_servico">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Prestador de Serviço
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: nr_seq_prestador_servico"></i>
                        </label>
                        <select id="nr_seq_prestador_servico"
                                name="nr_seq_prestador_servico"
                                class="form-control @error('nr_seq_prestador_servico') is-invalid @enderror"
                                required>
                            <option value="">---</option>
                            @foreach($prestadores as $prestador)
                                <option value="{{ $prestador->nr_sequencia }}"
                                    {{ old('nr_seq_prestador_servico', $manutencao->nr_seq_prestador_servico ?? '') == $prestador->nr_sequencia ? 'selected' : '' }}>
                                    {{ $prestador->ds_nome ?? $prestador->nm_fantasia }}
                                </option>
                            @endforeach
                        </select>
                        @error('nr_seq_prestador_servico')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="dt_envio">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Data Envio
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: dt_envio"></i>
                        </label>
                        <input
                            type="date"
                            name="dt_envio"
                            id="dt_envio"
                            class="form-control @error('dt_envio') is-invalid @enderror"
                            value="{{ old('dt_envio', isset($manutencao) ? $manutencao->dt_envio->format('Y-m-d') : now()->format('Y-m-d')) }}"
                            required>
                        @error('dt_envio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="dt_retorno">
                            Data Retorno
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: dt_retorno"></i>
                        </label>
                        <input type="date"
                            id="dt_retorno"
                            name="dt_retorno"
                            class="input-desabled form-control @error('dt_retorno') is-invalid @enderror"
                            value="{{ old('dt_retorno', isset($manutencao->dt_retorno) ? $manutencao->dt_retorno->format('Y-m-d') : '') }}" disabled>
                        @error('dt_retorno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="vl_final">
                            Valor Final
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: vl_final"></i>
                        </label>
                        <input type="text"
                            id="vl_final"
                            name="vl_final"
                            class="input-desabled form-control @error('vl_final') is-invalid @enderror"
                            value="{{ old('vl_final', $manutencao->vl_final ?? '') }}"
                            oninput="formatCurrency(this)" disabled>
                        @error('vl_final')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status"
                                name="ie_status"
                                class="form-select @error('ie_status') is-invalid @enderror"
                                required>
                            <option value="E" {{ old('ie_status', $manutencao->ie_status ?? '') == 'E' ? 'selected' : '' }}>Em curso</option>
                            <option value="C" {{ old('ie_status', $manutencao->ie_status ?? '') == 'C' ? 'selected' : '' }}>Concluída</option>
                        </select>
                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_observacao">
                        Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: manutencoes | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao"
                              name="ds_observacao"
                              rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $manutencao->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('manutencoes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length === 0) {
        input.value = '';
        return;
    }
    if (value.length === 1) {
        input.value = '0.0' + value;
    } else if (value.length === 2) {
        input.value = '0.' + value;
    } else {
        let integerPart = value.slice(0, -2);
        let decimalPart = value.slice(-2);
        input.value = parseInt(integerPart) + '.' + decimalPart;
    }
}
</script>
@endsection
