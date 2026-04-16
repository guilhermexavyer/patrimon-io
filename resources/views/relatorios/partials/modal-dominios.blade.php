<div id="modalDominios" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <span>Relatório de Domínios</span>
            <button class="btn-close-modal">&times;</button>
        </div>

        <div class="modal-body">
            <form method="GET" action="{{ route('relatorios.dominios.pdf') }}" target="_blank">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Todos</option>
                        <option value="A">Ativos</option>
                        <option value="I">Inativos</option>
                        <option value="E">Expirados</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Período de Vigência</label>
                    <div>
                        <input type="date" name="dt_inicio_vigencia" class="form-control mb-2">
                        <input type="date" name="dt_fim_vigencia" class="form-control">
                    </div>
                </div>

                <!--<div class="mb-3">
                    <label class="form-label">Faixa de Valor</label>
                    <div>
                        <input type="text" name="valor_min" placeholder="Valor mínimo" class="form-control mb-2">
                        <input type="text" name="valor_max" placeholder="Valor máximo" class="form-control">
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
    const valorInputs = document.querySelectorAll('#modalDominios input[name="valor_min"], #modalDominios input[name="valor_max"]');

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
