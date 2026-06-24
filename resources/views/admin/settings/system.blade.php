@extends('layouts.dashboard')

@section('title', 'Paramètres système')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Paramètres système</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            @php
                $existing = $settings->get('general', collect())->keyBy('key');
            @endphp

            @foreach($defaults as $key => $default)
                @php
                    $setting = $existing->get($key);
                @endphp
                <div class="mb-3">
                    <label class="form-label text-capitalize">{{ str_replace('_', ' ', $key) }}</label>
                    <input type="text" name="settings[{{ $key }}]" class="form-control" value="{{ old('settings.' . $key, $setting?->value ?? $default) }}">
                </div>
            @endforeach

            <button class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>
@endsection
