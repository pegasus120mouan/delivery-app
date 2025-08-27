<div class="modal fade" id="changeClientModal" tabindex="-1" aria-labelledby="changeClientModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="changeClientForm" method="POST" action="{{ route('commandes.changeBoutique') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="changeClientModalLabel">Changer la boutique</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
            <!-- Champ caché pour l'ID de la commande -->
            <input type="hidden" name="commande_id" id="client_commande_id">

            <div class="mb-3">
                <label for="boutique_id" class="form-label">Sélectionner la boutique</label>
                <select name="boutique_id" id="boutique_id" class="form-control" required>
                    <option value="">-- Choisir une boutique --</option>
                    @foreach($boutiques as $boutique)
                        <option value="{{ $boutique->id }}">{{ $boutique->nom_boutique }}</option>
                    @endforeach
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
    var changeClientModal = document.getElementById('changeClientModal');
changeClientModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var commandeId = button.getAttribute('data-id');
    var inputCommande = changeClientModal.querySelector('#client_commande_id');
    inputCommande.value = commandeId;
});
</script>