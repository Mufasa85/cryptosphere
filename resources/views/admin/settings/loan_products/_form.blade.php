<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="2">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Montant minimum</label>
        <input type="number" step="0.01" name="min_amount" class="form-control" value="{{ old('min_amount', $product->min_amount ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Montant maximum</label>
        <input type="number" step="0.01" name="max_amount" class="form-control" value="{{ old('max_amount', $product->max_amount ?? '') }}" required>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Taux d'intérêt (%)</label>
        <input type="number" step="0.01" name="interest_rate" class="form-control" value="{{ old('interest_rate', $product->interest_rate ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Durée (mois)</label>
        <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months', $product->duration_months ?? '') }}" required>
    </div>
</div>
<div class="mb-3 form-check">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Actif</label>
</div>
