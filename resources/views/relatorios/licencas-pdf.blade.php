<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
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
    <h2>{{ $titulo }}</h2>
    <p>Gerado em {{ date('d/m/Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Registro</th>
                <th>Vigência</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($licencas as $licenca)
                <tr>
                    <td>{{ $licenca->nr_sequencia }}</td>
                    <td>{{ $licenca->ds_nome }}</td>
                    <td>{{ $licenca->categoria->ds_nome ?? '' }}</td>
                    <td>{{ $licenca->fornecedor->ds_nome ?? $licenca->fornecedor->nm_fantasia }}</td>
                    <td>{{ $licenca->nr_registro ?? '-' }}</td>
                    <td>
                        {{ $licenca->dt_inicio_vigencia ? $licenca->dt_inicio_vigencia->format('d/m/Y') : '-' }}
                        até
                        {{ $licenca->dt_fim_vigencia ? $licenca->dt_fim_vigencia->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ number_format($licenca->vl_aquisicao, 2, ',', '.') }}</td>
                    <td>
                        @if($licenca->ie_status === 'A')
                            Ativa
                        @elseif($licenca->ie_status === 'E')
                            Expirada
                        @else
                            Inativa
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Nenhuma licença encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
