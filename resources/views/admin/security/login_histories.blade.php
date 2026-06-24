@extends('layouts.dashboard')

@section('title', 'Historique des connexions')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Historique des connexions</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>IP</th>
                        <th>User-Agent</th>
                        <th>Résultat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr>
                            <td>{{ $history->created_at?->format('d/m/Y H:i') }}</td>
                            <td>{{ $history->user?->name }}</td>
                            <td>{{ $history->ip_address ?? '-' }}</td>
                            <td class="text-truncate" style="max-width: 300px;" title="{{ $history->user_agent }}">{{ $history->user_agent ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $history->success ? 'success' : 'danger' }}">
                                    {{ $history->success ? 'Succès' : 'Échec' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Aucun historique.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $histories->links() }}
    </div>
</div>
@endsection
