<div id="modalLicencas" class="modal-overlay">
<div class="modal">
<div class="modal-header">
<span>Relatório de Licenças</span>
<button class="btn-close-modal">&times;</button>
</div>

<div class="modal-body">
<form method="GET" action="{{ route('relatorios.licencas.pdf') }}" target="_blank">
<!-- Categoria -->
<div class="mb-3">
<label class="form-label">Categoria</label>
<select name="categoria" class="form-control">
<option value="">Todas</option>
@foreach(\App\Models\CategoriaLicenca::where('ie_status','A')->orderBy('ds_nome')->get() as $categoria)
<option value="{{ $categoria->nr_sequencia }}">{{ $categoria->ds_nome }}</option>
@endforeach
</select>
</div>

<!-- Fornecedor -->
<div class="mb-3">
<label class="form-label">Fornecedor</label>
<select name="fornecedor" class="form-control">
<option value="">Todos</option>
@foreach(\App\Models\Fornecedor::where('ie_status','A')->orderBy('ds_nome')->get() as $fornecedor)
<option value="{{ $fornecedor->nr_sequencia }}">
{{ $fornecedor->ds_nome ?? $fornecedor->nm_fantasia }}
</option>
@endforeach
</select>
</div>

<!-- Status -->
<div class="mb-3">
<label class="form-label">Status</label>
<select name="status" class="form-control">
<option value="">Todos</option>
<option value="A">Ativas</option>
<option value="I">Inativas</option>
<option value="E">Expiradas</option>
</select>
</div>

<!-- Intervalo de Vigência -->
<div class="mb-3">
<label class="form-label">Período de Vigência</label>
<div>
<input type="date" name="dt_inicio_vigencia" class="form-control mb-2">
<input type="date" name="dt_fim_vigencia" class="form-control">
</div>
</div>

<!-- Faixa de Valor -->
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
const valorInputs = document.querySelectorAll('input[name="valor_min"], input[name="valor_max"]');

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
this.value = ''; // não exibe 0,00 quando o campo é apagado
return;
}
const valor = parseFloat(this.value.replace(',', '.'));
if (!isNaN(valor)) {
this.value = valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
} else {
this.value = '';
}
});
});
});
</script>

