<div class="modal fade" id="addBoutiqueModal" tabindex="-1" aria-labelledby="addBoutiqueModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('boutiques.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addBoutiqueModalLabel">Ajouter une boutique</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nom_boutique" class="form-label">Nom de la boutique</label>
            <input type="text" name="nom_boutique" id="nom_boutique" class="form-control" placeholder="Nom de la boutique" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Téléphone">
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control" placeholder="Adresse" required>
          </div>
          <div class="mb-3">
            <label for="commune" class="form-label">Commune</label>
            <input type="text" name="commune" id="commune" class="form-control" placeholder="Commune" required>
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
