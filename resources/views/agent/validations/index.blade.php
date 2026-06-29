@extends('layouts.dashboard')

@section('title', 'Validations')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root" style="padding:4px 0 0;">

    {{-- Header --}}
    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Dossiers à instruire</h1>
            <p class="at-page-subtitle">{{ $loans->total() }} dossier(s) en attente de validation</p>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="at-toolbar">
        <div class="at-search-wrap">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="atSearch" class="at-search" placeholder="Rechercher un dossier…">
        </div>
        <select id="atStatusFilter" class="at-filter-select">
            <option value="">Tous les statuts</option>
            <option value="submitted">Soumis</option>
            <option value="under_review">En cours</option>
            <option value="approved">Approuvé</option>
            <option value="rejected">Refusé</option>
        </select>
    </div>

    {{-- Table card --}}
    <div class="at-card" style="position:relative;">
        <div class="at-loader" id="atLoader"><div class="at-spinner"></div></div>

        <div class="at-table-wrap">
            <table class="at-table" id="atTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Référence <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(1)">Client <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(2)">Montant <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(3)">Durée <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(4)">Statut <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(5)">Date <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="atTbody">
                    @forelse($loans as $loan)
                        <tr data-status="{{ $loan->status }}">
                            <td>
                                <span class="at-ref">{{ $loan->reference }}</span>
                            </td>
                            <td>
                                <div class="at-user-cell">
                                    <div class="at-avatar">{{ strtoupper(substr($loan->user->name,0,1)) }}</div>
                                    <div class="at-user-name">{{ $loan->user->name }}</div>
                                </div>
                            </td>
                            <td style="font-weight:600;color:var(--text);">{{ number_format($loan->amount_requested, 2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span></td>
                            <td style="color:var(--muted);">{{ $loan->duration_months }} mois</td>
                            <td>
                                @php
                                    $badges = [
                                        'submitted'    => ['at-badge-blue',   'Soumis'],
                                        'under_review' => ['at-badge-orange', 'En cours'],
                                        'approved'     => ['at-badge-green',  'Approuvé'],
                                        'rejected'     => ['at-badge-red',    'Refusé'],
                                        'disbursed'    => ['at-badge-purple', 'Décaissé'],
                                        'running'      => ['at-badge-green',  'Actif'],
                                        'closed'       => ['at-badge-gray',   'Clôturé'],
                                    ];
                                    [$cls, $lbl] = $badges[$loan->status] ?? ['at-badge-gray', $loan->status];
                                @endphp
                                <span class="at-badge {{ $cls }}">{{ $lbl }}</span>
                            </td>
                            <td style="color:var(--muted);font-size:.82rem;">{{ $loan->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('agent.validations.show', $loan) }}" class="at-btn at-btn-primary at-btn-sm">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Instruire
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="at-empty">
                                <svg width="56" height="56" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                                <p>Aucun dossier à instruire pour le moment.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="at-table-footer">
            <span id="atCount"></span>
            {{ $loans->links() }}
        </div>
    </div>

</div>

@push('scripts')
<script>
(function () {
    const search = document.getElementById('atSearch');
    const filter = document.getElementById('atStatusFilter');
    const tbody  = document.getElementById('atTbody');
    const count  = document.getElementById('atCount');

    function applyFilters() {
        const q   = search.value.toLowerCase();
        const st  = filter.value.toLowerCase();
        let   vis = 0;

        tbody.querySelectorAll('tr[data-status]').forEach(tr => {
            const text   = tr.textContent.toLowerCase();
            const status = tr.dataset.status;
            const show   = text.includes(q) && (!st || status === st);
            tr.style.display = show ? '' : 'none';
            if (show) vis++;
        });

        count.textContent = vis + ' résultat(s) affiché(s)';
    }

    search.addEventListener('input',  applyFilters);
    filter.addEventListener('change', applyFilters);
    applyFilters();

    let sortDir = {};
    window.sortTable = function(col) {
        sortDir[col] = !sortDir[col];
        const rows = Array.from(tbody.querySelectorAll('tr[data-status]'));
        rows.sort((a, b) => {
            const va = a.cells[col]?.textContent.trim() ?? '';
            const vb = b.cells[col]?.textContent.trim() ?? '';
            return sortDir[col] ? va.localeCompare(vb) : vb.localeCompare(va);
        });
        rows.forEach(r => tbody.appendChild(r));
    };
})();
</script>
@endpush
@endsection
