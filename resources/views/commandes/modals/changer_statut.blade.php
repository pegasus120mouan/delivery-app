<div class="modal fade" id="changeStatutLivraisonModal" tabindex="-1" aria-labelledby="changeStatutLivraisonModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="changeStatutForm" method="POST" action="{{ route('commandes.changeStatut') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="changeStatutLivraisonModalLabel">Changer le statut de livraison</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
            <!-- Champ caché pour l'ID de la commande -->
            <input type="hidden" name="commande_id" id="statut_commande_id">

            <div class="mb-3">
                <label for="statut" class="form-label">Sélectionner le nouveau statut</label>
                <select name="statut" id="statut" class="form-control" required>
                    <option value="">-- Choisir un statut --</option>
                    <option value="Livré">Livré</option>
                    <option value="Non Livré">Non Livré</option>
                    <option value="Retourné">Retourné</option>
                </select>
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

<script>
        var changeStatutModal = document.getElementById('changeStatutLivraisonModal');
        changeStatutModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var commandeId = button.getAttribute('data-id');
            var inputCommande = changeStatutModal.querySelector('#statut_commande_id');
            inputCommande.value = commandeId;
        });
</script>


