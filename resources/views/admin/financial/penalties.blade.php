@extends('layouts.dashboard')

@section('title', 'Pénalités')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Pénalités</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Crédit</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Raison</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penalties as $penalty)
                        <tr>
                            <td>{{ $penalty->id }}</td>
                            <td>{{ $penalty->loanApplication?->reference ?? '-' }}</td>
                            <td>{{ $penalty->user?->name ?? '-' }}</td>
                            <td>{{ number_format($penalty->amount, 2) }} CDF</td>
                            <td>{{ $penalty->reason ?? '-' }}</td>
                            <td><span class="badge bg-{{ $penalty->status === 'paid' ? 'success' : ($penalty->status === 'waived' ? 'secondary' : 'warning') }}">{{ $penalty->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Aucune pénalité.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $penalties->links() }}
    </div>
</div>
@endsection
