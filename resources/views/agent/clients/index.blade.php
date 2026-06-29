@extends('layouts.dashboard')

@section('title', 'Clients')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Clients</h1>
            <p class="at-page-subtitle">{{ $clients->total() }} client(s) enregistré(s)</p>
        </div>
    </div>

    <div class="at-toolbar">
        <div class="at-search-wrap">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="atSearch" class="at-search" placeholder="Rechercher un client…">
        </div>
    </div>

    <div class="at-card" style="position:relative;">
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Nom <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(1)">Email <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(2)">Téléphone <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(3)">Demandes <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="atTbody">
                    @forelse($clients as $client)
                        <tr data-status="active">
                            <td>
                                <div class="at-user-cell">
                                    <div class="at-avatar">{{ strtoupper(substr($client->name,0,1)) }}</div>
                                    <div>
                                        <div class="at-user-name">{{ $client->name }}</div>
                                        <div class="at-user-sub">{{ $client->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--muted);font-size:.83rem;">{{ $client->email }}</td>
                            <td>
                                @if($client->phone)
                                    <span style="display:inline-flex;align-items:center;gap:5px;color:var(--text);">
                                        <svg width="13" height="13" fill="none" stroke="var(--neon)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.53 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.95-1.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 15z"/></svg>
                                        {{ $client->phone }}
                                    </span>
                                @else
                                    <span class="at-badge at-badge-gray">Non renseigné</span>
                                @endif
                            </td>
                            <td>
                                <span class="at-badge at-badge-blue">
                                    {{ $client->loan_applications_count }} demande(s)
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('agent.clients.show', $client) }}" class="at-btn at-btn-ghost at-btn-sm">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">
                            <div class="at-empty">
                                <svg width="56" height="56" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <p>Aucun client enregistré.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="at-table-footer">
            <span id="atCount"></span>
            {{ $clients->links() }}
        </div>
    </div>

</div>

@push('scripts')
<script>
(function () {
    const search = document.getElementById('atSearch');
    const tbody  = document.getElementById('atTbody');
    const count  = document.getElementById('atCount');

    function applyFilters() {
        const q = search.value.toLowerCase();
        let vis = 0;
        tbody.querySelectorAll('tr[data-status]').forEach(tr => {
            const show = tr.textContent.toLowerCase().includes(q);
            tr.style.display = show ? '' : 'none';
            if (show) vis++;
        });
        count.textContent = vis + ' résultat(s) affiché(s)';
    }

    search.addEventListener('input', applyFilters);
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
