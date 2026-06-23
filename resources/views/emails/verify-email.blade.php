@component('mail::message')
# Confirmez votre adresse email

Bonjour {{ $user->name }},

Cliquez sur le bouton ci-dessous pour confirmer votre adresse email.

@component('mail::button', ['url' => $url])
Confirmer mon email
@endcomponent

Si vous n'avez pas créé de compte, ignorez ce message.

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
