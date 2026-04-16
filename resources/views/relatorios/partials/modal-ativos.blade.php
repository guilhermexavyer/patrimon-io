<div id="modalAtivos" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <span>Relatório de Ativos</span>
            <button class="btn-close-modal" data-target="modalAtivos">&times;</button>
        </div>

        <div class="modal-body">
            <form id="formAtivos" method="GET" action="{{ route('relatorios.ativos.pdf') }}" target="_blank">
                
                <div class="mb-3">
                    <label class="form-label">Categoria</label>
                    <select name="categoria" class="form-control">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->nr_sequencia }}">{{ $categoria->ds_nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Localização</label>
                    <select name="localizacao" class="form-control">
                        <option value="">Todas</option>
                        @foreach($localizacoes as $localizacao)
                            <option value="{{ $localizacao->nr_sequencia }}">{{ $localizacao->ds_nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fornecedor</label>
                    <select name="fornecedor" class="form-control">
                        <option value="">Todos</option>
                        @foreach($fornecedores as $fornecedor)
                            <option value="{{ $fornecedor->nr_sequencia }}">
                                {{ $fornecedor->ds_nome ? $fornecedor->ds_nome : $fornecedor->nm_fantasia }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Todos</option>
                        <option value="A">Ativo</option>
                        <option value="I">Inativo</option>
                        <option value="D">Descartado</option>
                        <option value="M">Em Manutenção</option>
                    </select>
                </div>

                <!--<div class="mb-3">
                    <label class="form-label">Faixa de Valor</label>
                    <div>
                        <input type="text" name="valor_min" placeholder="Valor mínimo" class="form-control mb-2 currency-input">
                        <input type="text" name="valor_max" placeholder="Valor máximo" class="form-control currency-input">
                    </div>
                </div>-->

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gerar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
