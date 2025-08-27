<div class="modal fade" id="printPointModal" tabindex="-1" aria-labelledby="printPointModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('point.imprimer') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="printPointModalLabel">Imprimer un point</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Select boutiques -->
          <div class="mb-3">
            <label for="boutique" class="form-label">Boutique</label>
            <select name="boutique_id" id="boutique" class="form-select" required>
              <option value="">-- Sélectionner une boutique --</option>
              @foreach($boutiques as $boutique)
                <option value="{{ $boutique->id }}">{{ $boutique->nom_boutique }}</option>
              @endforeach
            </select>
          </div>

          <!-- Champ date -->
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Imprimer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>
