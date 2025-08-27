<div class="modal fade" id="addPointModal" tabindex="-1" aria-labelledby="addPointModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('points_livreurs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addPointModalLabel">Ajouter un point</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="utilisateur_id" class="form-label">Livreurs</label>
            <select name="utilisateur_id" id="utilisateur_id" class="form-control" required>
                <option value="">Sélectionner un livreurs</option>
                @foreach ($utilisateurs as $utilisateur)
                    <option value="{{ $utilisateur->id }}">{{ $utilisateur->nom }} {{ $utilisateur->prenoms }}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="recettes" class="form-label">Recettes</label>
            <input type="number" name="recettes" id="recettes" class="form-control" placeholder="Recettes">
          </div>
          <div class="mb-3">
            <label for="depenses" class="form-label">Dépenses</label>
            <input type="number" name="depenses" id="depenses" class="form-control" placeholder="Dépenses" required>
          </div>
          <div class="mb-3">
            <label for="date_jour" class="form-label">Date du jour</label>
            <input type="date" name="date_jour" id="date_jour" class="form-control" placeholder="Date du jour" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>