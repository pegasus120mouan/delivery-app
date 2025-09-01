<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('delivery_services.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addServiceModalLabel">Ajouter un service de livraison</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nom_service" class="form-label">Nom du service</label>
            <input type="text" name="nom_service" id="nom_service" class="form-control" placeholder="Nom du service" required>
          </div>
          <div class="mb-3">
            <label for="contact_service" class="form-label">Contact</label>
            <input type="text" name="contact_service" id="contact_service" class="form-control" placeholder="Téléphone ou email">
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