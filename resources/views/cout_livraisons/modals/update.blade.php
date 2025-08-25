<div class="modal fade" id="editCoutLivraisonModal" tabindex="-1" aria-labelledby="editCoutLivraisonModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editCoutLivraisonForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editCoutLivraisonModalLabel">Modifier un cout de livraison</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Montant</label>
            <input type="text" name="cout_livraison" id="edit_cout_livraison" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Mettre à jour</button>
        </div>
      </form>
    </div>
  </div>
</div>