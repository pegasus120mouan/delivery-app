<div class="modal fade" id="updateCommandeModal" tabindex="-1" aria-labelledby="updateCommandeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="updateCommandeForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="updateCommandeModalLabel">Modifier la commande</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          
          <input type="hidden" name="id" id="edit_id">

          <div class="mb-3">
            <label for="edit_communes">Communes</label>
            <input type="text" id="edit_communes" name="communes" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_cout_global">Cout global</label>
            <input type="number" id="edit_cout_global" name="cout_global" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_cout_livraison">Cout livraison</label>
            <input type="number" id="edit_cout_livraison" name="cout_livraison" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_date_reception">Date de reception</label>
            <input type="date" id="edit_date_reception" name="date_reception" class="form-control">
          </div>
          <!-- tu continues pour les autres champs -->
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
