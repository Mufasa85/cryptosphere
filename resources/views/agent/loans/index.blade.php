@extends('layouts.dashboard')

@section('title', 'Tous les crédits')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Tous les crédits</h1>
            <p class="at-page-subtitle">{{ $loans->total() }} dossier(s) au total</p>
        </div>
    </div>

    <div class="at-toolbar">
        <div class="at-search-wrap">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="atSearch" class="at-search" placeholder="Référence, client, agent…">
        </div>
        <select id="atStatusFilter" class="at-filter-select">
            <option value="">Tous les statuts</option>
            <option value="submitted">Soumis</option>
            <option value="under_review">En cours</option>
            <option value="approved">Approuvé</option>
            <option value="rejected">Refusé</option>
            <option value="disbursed">Décaissé</option>
            <option value="running">Actif</option>
            <option value="closed">Clôturé</option>
        </select>
    </div>

    <div class="at-card" style="position:relative;">
        <div class="at-loader" id="atLoader"><div class="at-spinner"></div></div>
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Référence <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(1)">Client <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(2)">Montant <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(3)">Statut <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(4)">Agent <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(5)">Date <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                    </tr>
                </thead>
                <tbody id="atTbody">
                    @forelse($loans as $loan)
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
                        <tr data-status="{{ $loan->status }}">
                            <td>
                                <a href="{{ route('agent.loans.show', $loan) }}" class="at-ref at-ref-link">
                                    {{ $loan->reference }}
                                </a>
                            </td>
                            <td>
                                <div class="at-user-cell">
                                    <div class="at-avatar">{{ strtoupper(substr($loan->user->name,0,1)) }}</div>
                                    <div>
                                        <div class="at-user-name">{{ $loan->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight:600;color:var(--text);">{{ number_format($loan->amount_requested, 2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span></td>
                            <td><span class="at-badge {{ $cls }}">{{ $lbl }}</span></td>
                            <td style="color:var(--muted);">{{ $loan->agent?->name ?? '—' }}</td>
                            <td style="color:var(--muted);font-size:.82rem;">{{ $loan->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="at-empty">
                                <svg width="52" height="52" fill="none" stroke="#334155" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                                <p>Aucun crédit enregistré.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="at-table-footer">
            <span id="atCount" style="color:var(--muted);font-size:.82rem;"></span>
            {{ $loans->links() }}
        </div>
    </div>

</div>

@push('scripts')
<script>
(function(){
    const search = document.getElementById('atSearch');
    const filter = document.getElementById('atStatusFilter');
    const tbody  = document.getElementById('atTbody');
    const count  = document.getElementById('atCount');
    function apply(){
        const q=search.value.toLowerCase(), st=filter.value;
        let v=0;
        tbody.querySelectorAll('tr[data-status]').forEach(tr=>{
            const show=tr.textContent.toLowerCase().includes(q)&&(!st||tr.dataset.status===st);
            tr.style.display=show?'':'none'; if(show)v++;
        });
        count.textContent=v+' résultat(s)';
    }
    search.addEventListener('input',apply);
    filter.addEventListener('change',apply);
    apply();
    let dir={};
    window.sortTable=function(c){
        dir[c]=!dir[c];
        const rows=Array.from(tbody.querySelectorAll('tr[data-status]'));
        rows.sort((a,b)=>{const va=a.cells[c]?.textContent.trim()??'',vb=b.cells[c]?.textContent.trim()??'';return dir[c]?va.localeCompare(vb):vb.localeCompare(va);});
        rows.forEach(r=>tbody.appendChild(r));
    };
})();
</script>
@endpush
@endsection
