<div class="modal fade" id="attribuerLivreurModal" tabindex="-1" aria-labelledby="attribuerLivreurModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="attribuerLivreurForm" method="POST" action="{{ route('commandes.attribuerLivreur') }}">

        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="attribuerLivreurModalLabel">Attribuer un livreur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="commande_id" id="commande_id">

            <div class="mb-3">
                <label for="livreur_id" class="form-label">Sélectionner un livreur</label>
                <select name="livreur_id" id="livreur_id" class="form-control" required>
                    <option value="">-- Choisir un livreur --</option>
                    @foreach($livreurs as $livreur)
                        <option value="{{ $livreur->id }}">{{ $livreur->nom }} {{ $livreur->prenoms }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Attribuer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script pour remplir l'ID de la commande -->
<script>
var attribuerLivreurModal = document.getElementById('attribuerLivreurModal')
attribuerLivreurModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget // bouton qui a déclenché le modal
    var commandeId = button.getAttribute('data-id')
    var inputCommande = attribuerLivreurModal.querySelector('#commande_id')
    inputCommande.value = commandeId
})
</script>
