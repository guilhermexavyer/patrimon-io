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
                <th>Modelo</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Localização</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ativos as $ativo)
            <tr>
                <td>{{ $ativo->nr_sequencia }}</td>
                <td>{{ $ativo->ds_nome }}</td>
                <td>{{ $ativo->ds_modelo }}</td>
                <td>{{ $ativo->categoria->ds_nome ?? '' }}</td>
                <td>{{ $ativo->fornecedor?->ds_nome ?? $ativo->fornecedor?->nm_fantasia ?? '' }}</td>
                <td>{{ $ativo->localizacao->ds_nome ?? '' }}</td>
                <td>{{ number_format($ativo->vl_aquisicao, 2, ',', '.') }}</td>
                <td>
                    @if($ativo->ie_status === 'A')
                        Ativo
                    @elseif($ativo->ie_status === 'I')
                        Inativo
                    @else
                        Em manutenção
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Nenhum ativo encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
