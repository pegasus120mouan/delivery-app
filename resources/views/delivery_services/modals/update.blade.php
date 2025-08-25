<div class="modal fade" id="updateServiceModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="updateServiceForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Modifier Service de Livraison</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="service_id">

          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="service_nom" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="service_email" required>
          </div>

          <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" name="telephone" id="service_telephone">
          </div>

          <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" name="adresse" id="service_adresse">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Enregistrer</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>
