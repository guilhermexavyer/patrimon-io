<div id="modalManutencoes" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <span>Relatório de Manutenções</span>
            <button class="btn-close-modal">&times;</button>
        </div>

        <div class="modal-body">
            <form method="GET" action="{{ route('relatorios.manutencoes.pdf') }}" target="_blank">
                <div class="mb-3">
                    <label class="form-label">Ativo</label>
                    <select name="ativo" class="form-control">
                        <option value="">Todos</option>
                        @foreach(\App\Models\Ativo::orderBy('ds_nome')->get() as $ativo)
                            <option value="{{ $ativo->nr_sequencia }}">
                                {{ $ativo->ds_nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prestador de Serviço</label>
                    <select name="prestador" class="form-control">
                        <option value="">Todos</option>
                        @foreach(\App\Models\PrestadorServico::where('ie_status', 'A')->orderBy('ds_nome')->get() as $prestador)
                            <option value="{{ $prestador->nr_sequencia }}">
                                {{ $prestador->ds_nome ?? $prestador->nm_fantasia ?? 'Prestador '.$prestador->nr_sequencia }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-control">
                        <option value="">Todos</option>
                        <option value="C">Corretiva</option>
                        <option value="P">Preventiva</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Todos</option>
                        <option value="E">Em curso</option>
                        <option value="C">Concluída</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Período de Envio</label>
                    <div>
                        <input type="date" name="dt_inicio" class="form-control mb-2">
                        <input type="date" name="dt_fim" class="form-control">
                    </div>
                </div>

                <!--<div class="mb-3">
                    <label class="form-label">Faixa de Valor</label>
                    <div>
                        <input type="text" name="vl_min" placeholder="Valor mínimo" class="form-control mb-2">
                        <input type="text" name="vl_max" placeholder="Valor máximo" class="form-control">
                    </div>
                </div>-->

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gerar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const valorInputs = document.querySelectorAll('#modalManutencoes input[name="vl_min"], #modalManutencoes input[name="vl_max"]');

    valorInputs.forEach(input => {
        input.addEventListener('keyup', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            if (!v) {
                e.target.value = '';
                return;
            }
            v = (v / 100).toFixed(2) + '';
            v = v.replace('.', ',');
            v = v.replace(/(\d)(\d{3})(\d{3}),/, '$1.$2.$3,');
            v = v.replace(/(\d)(\d{3}),/, '$1.$2,');
            e.target.value = v;
        });

        input.addEventListener('focus', function () {
            this.value = this.value.replace(/[^\d,]/g, '').replace(',', '.');
        });

        input.addEventListener('blur', function () {
            if (this.value === '' || this.value === '0' || this.value === '0,00') {
                this.value = '';
                return;
            }
            const valor = parseFloat(this.value.replace(',', '.'));
            if (!isNaN(valor)) {
                this.value = valor.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                this.value = '';
            }
        });
    });
});
</script>
