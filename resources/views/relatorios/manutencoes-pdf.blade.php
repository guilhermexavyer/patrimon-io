<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Manutenções</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #e0e0e0; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <h2>Relatório de Manutenções</h2>
    <p>Gerado em {{ date('d/m/Y H:i:s') }}</p>

    @if(request('ativo'))
        <p>Ativo: {{ $manutencoes->first()->ativo->ds_nome ?? '---' }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Ativo</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Prestador</th>
                <th>Data Envio</th>
                <th>Data Retorno</th>
                <th>Valor Final (R$)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($manutencoes as $m)
                <tr>
                    <td class="center">{{ $m->nr_sequencia }}</td>
                    <td>{{ $m->ativo->ds_nome ?? '---' }}</td>
                    <td>{{ $m->tipo_texto }}</td>
                    <td>{{ $m->status_texto }}</td>
                    <td>{{ $m->prestador->ds_nome ?? $m->prestador->nm_fantasia }}</td>
                    <td>{{ $m->dt_envio ? $m->dt_envio->format('d/m/Y') : '---' }}</td>
                    <td>{{ $m->dt_retorno ? $m->dt_retorno->format('d/m/Y') : '---' }}</td>
                    <td class="center">
                        {{ $m->vl_final ? number_format($m->vl_final, 2, ',', '.') : '—' }}
                    </td>
                    
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center">Nenhuma manutenção encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
