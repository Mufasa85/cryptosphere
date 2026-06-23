@component('mail::message')
# Bienvenue {{ $user->name }},

Merci d'avoir créé un compte sur **{{ config('app.name') }}**.

Vous pouvez dès maintenant soumettre une demande de crédit et suivre vos remboursements.

@component('mail::button', ['url' => route('login')])
Accéder à mon compte
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
