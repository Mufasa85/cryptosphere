@component('mail::message')
# Votre code de vérification

Bonjour {{ $user->name }},

Voici votre code de vérification à usage unique :

@component('mail::panel')
# {{ $code }}
@endcomponent

Ce code expire dans 10 minutes.

Si vous n'avez pas tenté de vous connecter, ignorez cet email.

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
