<div class="modal fade" id="addCoutLivraisonModal" tabindex="-1" aria-labelledby="addCoutLivraisonModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('cout_livraisons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addServiceModalLabel">Ajouter un cout de livraison</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="cout_livraison" class="form-label">Cout de livraison</label>
            <input type="text" name="cout_livraison" id="cout_livraison" class="form-control" placeholder="Cout de livraison" required>
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