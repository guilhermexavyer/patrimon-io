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
                <th>URL</th>
                <th>IP</th>
                <th>Registro</th>
                <th>Vigência</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dominios as $dominio)
                <tr>
                    <td>{{ $dominio->nr_sequencia }}</td>
                    <td>{{ $dominio->ds_nome }}</td>
                    <td>{{ $dominio->ds_url }}</td>
                    <td>{{ $dominio->nr_ip }}</td>
                    <td>{{ $dominio->nr_registro }}</td>
                    <td>
                        {{ $dominio->dt_inicio_vigencia ? $dominio->dt_inicio_vigencia->format('d/m/Y') : '-' }}
                        até
                        {{ $dominio->dt_fim_vigencia ? $dominio->dt_fim_vigencia->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ number_format($dominio->vl_aquisicao, 2, ',', '.') }}</td>
                    <td>
                        @if($dominio->ie_status === 'A')
                            Ativo
                        @elseif($dominio->ie_status === 'E')
                            Expirado
                        @else
                            Inativo
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Nenhum domínio encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
