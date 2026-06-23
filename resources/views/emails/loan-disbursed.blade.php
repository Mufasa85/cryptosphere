@component('mail::message')
# Votre crédit a été décaissé

Bonjour {{ $loan->user->name }},

Votre demande **{{ $loan->reference }}** d'un montant de **{{ number_format($loan->amount_approved, 2) }}** a été décaissée.

Le tableau d'amortissement est disponible dans votre espace client.

@component('mail::button', ['url' => route('client.loans.show', $loan)])
Voir mon crédit
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
