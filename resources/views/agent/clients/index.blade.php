@extends('layouts.dashboard')

@section('title', 'Clients')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Clients</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Demandes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->loan_applications_count }}</td>
                    <td>
                        <a href="{{ route('agent.clients.show', $client) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Aucun client.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $clients->links() }}
@endsection
