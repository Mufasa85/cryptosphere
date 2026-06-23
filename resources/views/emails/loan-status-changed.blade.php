@component('mail::message')
# Mise à jour de votre demande de crédit

Bonjour {{ $loan->user->name }},

Le statut de votre demande **{{ $loan->reference }}** a changé : **{{ $status }}**.

@if($loan->rejection_reason)
**Motif :** {{ $loan->rejection_reason }}
@endif

@component('mail::button', ['url' => route('client.loans.show', $loan)])
Consulter la demande
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
