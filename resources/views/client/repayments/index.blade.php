@extends('layouts.dashboard')

@section('title', 'Mes remboursements')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Mes remboursements</h1>
            <p class="at-page-subtitle">{{ $repayments->total() }} paiement(s) enregistré(s)</p>
        </div>
    </div>

    <div class="at-toolbar">
        <div class="at-search-wrap">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="atSearch" class="at-search" placeholder="Référence, numéro…">
        </div>
        <select id="atStatusFilter" class="at-filter-select">
            <option value="">Tous les statuts</option>
            <option value="confirmed">Confirmé</option>
            <option value="pending">En attente</option>
            <option value="processing">En cours</option>
            <option value="failed">Échoué</option>
        </select>
    </div>

    <div class="at-card" style="position:relative;">
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Réf. crédit <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(1)">Montant <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(2)">Méthode <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(3)">Numéro mobile <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(4)">Statut <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th onclick="sortTable(5)">Date <span class="sort-icon"><span class="up"></span><span class="down"></span></span></th>
                        <th>Reçu</th>
                    </tr>
                </thead>
                <tbody id="atTbody">
                    @forelse($repayments as $repayment)
                        @php
                            $badges=['confirmed'=>['at-badge-green','Confirmé'],'pending'=>['at-badge-orange','En attente'],'processing'=>['at-badge-blue','En cours'],'failed'=>['at-badge-red','Échoué']];
                            [$cls,$lbl]=$badges[$repayment->status]??['at-badge-gray',$repayment->status];
                        @endphp
                        <tr data-status="{{ $repayment->status }}">
                            <td><span class="at-ref">{{ $repayment->loanApplication->reference }}</span></td>
                            <td style="font-weight:600;color:var(--text);">{{ number_format($repayment->amount, 2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span></td>
                            <td style="color:var(--muted);">{{ $repayment->payment_method }}</td>
                            <td style="color:var(--muted);font-size:.83rem;">{{ $repayment->mobile_number }}</td>
                            <td><span class="at-badge {{ $cls }}">{{ $lbl }}</span></td>
                            <td style="color:var(--muted);font-size:.82rem;">{{ $repayment->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('client.repayments.receipt', $repayment) }}" class="at-btn-icon" title="Télécharger le reçu" target="_blank">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="at-empty">
                                <svg width="48" height="48" fill="none" stroke="#142634" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                <p>Aucun remboursement enregistré.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="at-table-footer">
            <span id="atCount" style="color:var(--muted);font-size:.82rem;"></span>
            {{ $repayments->links() }}
        </div>
    </div>

</div>

@push('scripts')
<script>
(function(){
    const search=document.getElementById('atSearch');
    const filter=document.getElementById('atStatusFilter');
    const tbody=document.getElementById('atTbody');
    const count=document.getElementById('atCount');
    function apply(){
        const q=search.value.toLowerCase(),st=filter.value;
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
