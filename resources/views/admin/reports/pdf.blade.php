<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Rapport d'activité - {{ now()->format('d/m/Y') }}</h1>
    <p>Application : {{ config('app.name') }}</p>

    <h3>Statistiques globales</h3>
    <ul>
        <li>Utilisateurs : {{ $stats['users_count'] }}</li>
        <li>Clients : {{ $stats['clients_count'] }}</li>
        <li>Agents : {{ $stats['agents_count'] }}</li>
        <li>Crédits : {{ $stats['loans_count'] }}</li>
        <li>Total décaissé : {{ number_format($stats['total_disbursed'], 2) }} CDF</li>
        <li>Total remboursé : {{ number_format($stats['repayments_total'], 2) }} CDF</li>
    </ul>

    <h3>Volume mensuel</h3>
    <table>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Nombre</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthly as $row)
                <tr>
                    <td>{{ $row['month'] }}</td>
                    <td>{{ $row['count'] }}</td>
                    <td>{{ number_format($row['amount'], 2) }} CDF</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
