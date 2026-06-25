<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport d'activité - MicroCredit</title>
    <style>
        /* DomPDF-friendly minimal CSS */
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; background: #fff; }

        .container { padding: 18px; }
        .row { width: 100%; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid rgba(20,38,52,1); padding: 8px; text-align: left; }
        th { background: #fff; color: #000; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: .02em; }

        .muted { color: #000; }

        .h1 { font-size: 18px; font-weight: 900; margin: 0; }
        .h2 { font-size: 13px; font-weight: 900; margin: 14px 0 8px; }
        .pill { display: inline-block; padding: 6px 10px; border-radius: 999px; border: 1px solid #142634; background: rgba(13,24,35,.6); font-weight: 800; }
        .card { border: 1px solid #142634; background: #ebedef; border-radius: 12px; padding: 12px; }
        .grid-2 { width: 100%; }
        .stats { width: 100%; }
        .stat-grid { width: 100%; display: table; }
        .stat-cell { width: 16.66%; display: table-cell; padding: 6px; }
        .stat-box { border: 1px solid #142634; background: rgba(13,24,35,.7); border-radius: 12px; padding: 10px; }
        .stat-ico { font-size: 16px; margin-bottom: 6px; }
        .stat-value { font-size: 16px; font-weight: 1000; color: #E9F2F7; }
        .kpi-green { color: #3DFF7A; }
        .kpi-gold { color: #C8A24B; }
        .kpi-blue { color: #49A7FF; }
        .kpi-red { color: #FF6B6B; }
        .bar { height: 8px; background: #142634; border-radius: 999px; overflow: hidden; margin-top: 6px; }
        .bar > div { height: 100%; background: #3DFF7A; }
        .two-col { width: 100%; }
        .two-col td { vertical-align: top; }
        .small { font-size: 10px; }
        .footer { margin-top: 18px; padding-top: 12px; border-top: 1px solid #142634; color: #AEBBC6; font-size: 10px; }
        .page-num { margin-top: 8px; }
        /* Prevent DomPDF issues */
        .mb-10 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <table style="border-collapse:collapse; border:none;" class="row">
            <tr>
                <td style="width: 25%; border:none;">
                    <div class="card" style="padding:10px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                <img src="{{ public_path('logo.png') }}" alt="MicroCredit" style="width:34px; height:34px; object-fit:cover;" />
                            </div>
                            <div style="font-weight:1000; font-size:14px;">MicroCredit</div>
                        </div>
                    </div>

                </td>
                <td style="border:none;" colspan="2">
                    <div class="h1">RAPPORT D’ACTIVITÉ</div>
                    <div class="muted" style="margin-top:6px;">
                        <div><b>Date de génération :</b> {{ now()->format('d/m/Y') }}</div>
                        <div><b>Référence du rapport :</b> MC-{{ now()->format('Ymd') }}-{{ strtoupper(substr(auth()->user()->name ?? 'ADMIN',0,4)) }}</div>
                        <div><b>Agent générateur :</b> {{ auth()->user()->name ?? 'Admin' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Executive summary --}}
        <div class="h2">Résumé exécutif</div>
        <div class="stat-grid" style="width:100%; border-spacing:0;">
            @php
                $kpiUsers   = $stats['users_count'] ?? 0;
                $kpiClients = $stats['clients_count'] ?? 0;
                $kpiAgents  = $stats['agents_count'] ?? 0;

                $kpiLoans = $stats['loans_count'] ?? 0;
                $kpiDisbursed = $stats['total_disbursed'] ?? 0;
                $kpiRepaid = $stats['repayments_total'] ?? 0;

                // Best-effort evolution: use 0% if unknown
                $evo = fn($v) => '+0%';
            @endphp

            <div class="stat-cell">
                <div class="stat-box">
                    <div class="stat-ico"></div>
                    <div class="stat-value">{{ $kpiUsers }}</div>
                    <div class="muted small">Utilisateurs</div>
                    <div class="small kpi-green">Évolution : {{ $evo($kpiUsers) }}</div>
                </div>
            </div>
            <div class="stat-cell">
                <div class="stat-box">
                    <div class="stat-ico"></div>
                    <div class="stat-value">{{ $kpiClients }}</div>
                    <div class="muted small">Clients</div>
                    <div class="small kpi-blue">Évolution : {{ $evo($kpiClients) }}</div>
                </div>
            </div>
            <div class="stat-cell">
                <div class="stat-box">
                    <div class="stat-ico"></div>
                    <div class="stat-value">{{ $kpiAgents }}</div>
                    <div class="muted small">Agents</div>
                    <div class="small kpi-gold">Évolution : {{ $evo($kpiAgents) }}</div>
                </div>
            </div>
            <div class="stat-cell">
                <div class="stat-box">
                    <div class="stat-ico"></div>
                    <div class="stat-value">{{ $kpiLoans }}</div>
                    <div class="muted small">Crédits accordés</div>
                    <div class="small kpi-green">Évolution : {{ $evo($kpiLoans) }}</div>
                </div>
            </div>
            <div class="stat-cell">
                <div class="stat-box">
                    <div class="stat-ico"></div>
                    <div class="stat-value">{{ number_format($kpiDisbursed,2,',',' ') }} CDF</div>
                    <div class="muted small">Total décaissé</div>
                    <div class="small kpi-gold">Évolution : {{ $evo($kpiDisbursed) }}</div>
                </div>
            </div>
            <div class="stat-cell">
                <div class="stat-box">
                    <div class="stat-ico"></div>
                    <div class="stat-value">{{ number_format($kpiRepaid,2,',',' ') }} CDF</div>
                    <div class="muted small">Total remboursé</div>
                    <div class="small kpi-green">Évolution : {{ $evo($kpiRepaid) }}</div>
                </div>
            </div>
        </div>

        {{-- Financial analysis --}}
        <div class="h2">Analyse financière</div>
        <table>
            <thead>
                <tr>
                    <th>Indicateur</th>
                    <th>Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Montant total prêté</td>
                    <td>{{ number_format($stats['total_disbursed'] ?? 0, 2, ',', ' ') }} CDF</td>
                </tr>
                <tr>
                    <td>Montant remboursé</td>
                    <td>{{ number_format($stats['repayments_total'] ?? 0, 2, ',', ' ') }} CDF</td>
                </tr>
                <tr>
                    <td>Intérêts générés</td>
                    <td>{{ number_format($stats['interest_generated'] ?? 0, 2, ',', ' ') }} CDF</td>
                </tr>
                <tr>
                    <td>Taux de remboursement</td>
                    <td>
                        @php
                            $dis = (float)($stats['total_disbursed'] ?? 0);
                            $rep = (float)($stats['repayments_total'] ?? 0);
                            $ratio = $dis > 0 ? ($rep / $dis) * 100 : 0;
                        @endphp
                        {{ number_format($ratio, 2, ',', ' ') }} %
                    </td>
                </tr>
                <tr>
                    <td>Crédits actifs</td>
                    <td>{{ $stats['active_loans'] ?? ($stats['loans_count'] ?? 0) }}</td>
                </tr>
                <tr>
                    <td>Crédits clôturés</td>
                    <td>{{ $stats['closed_loans'] ?? 0 }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Monthly volume --}}
        <div class="h2">Volume mensuel</div>
        <table>
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>Nombre de crédits</th>
                    <th>Montant total</th>
                    <th>Montant remboursé</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthly as $row)
                    @php
                        $count = $row['count'] ?? 0;
                        $amount = $row['amount'] ?? 0;
                        $repaid = $row['repaid'] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $row['month'] ?? '-' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format((float)$amount, 2, ',', ' ') }} CDF</td>
                        <td>{{ $repaid !== null ? number_format((float)$repaid, 2, ',', ' ') . ' CDF' : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Top clients & Risk analysis best-effort placeholders (if not provided) --}}
        <div class="h2">Top clients</div>
        @php $topClients = $topClients ?? []; @endphp
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Nombre de prêts</th>
                    <th>Montant emprunté</th>
                    <th>Montant remboursé</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topClients as $c)
                    <tr>
                        <td>{{ $c['name'] ?? '-' }}</td>
                        <td>{{ $c['count'] ?? 0 }}</td>
                        <td>{{ number_format((float)($c['borrowed'] ?? 0),2,',',' ') }} CDF</td>
                        <td>{{ number_format((float)($c['repaid'] ?? 0),2,',',' ') }} CDF</td>
                        <td>{{ $c['status'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">Données non disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="h2">Analyse des risques</div>
        @php
            $riskOk = $riskOk ?? 0;
            $riskLate = $riskLate ?? 0;
            $riskBad = $riskBad ?? 0;
            $riskTotal = max(1, (float)($riskOk + $riskLate + $riskBad));
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>🟢 Crédits remboursés</td>
                    <td>{{ number_format((float)$riskOk / $riskTotal * 100, 2, ',', ' ') }} %</td>
                </tr>
                <tr>
                    <td>🟡 Crédits en retard</td>
                    <td>{{ number_format((float)$riskLate / $riskTotal * 100, 2, ',', ' ') }} %</td>
                </tr>
                <tr>
                    <td>🔴 Crédits impayés</td>
                    <td>{{ number_format((float)$riskBad / $riskTotal * 100, 2, ',', ' ') }} %</td>
                </tr>
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="footer">
            <div>MicroCredit © 2026 — Confidentiel</div>
        </div>
    </div>
</body>
</html>

