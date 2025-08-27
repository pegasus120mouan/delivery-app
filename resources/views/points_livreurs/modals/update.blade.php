<div class="modal fade" id="updatePointLivreurModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="updatePointLivreurForm" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" id="edit_id">

        <div class="modal-header">
          <h5 class="modal-title">Modifier Point Livreur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
        <div class="mb-3">
          <label for="edit_utilisateur">Livreur</label>
          <input type="text" id="edit_utilisateur" class="form-control" readonly>
          <input type="hidden" id="edit_utilisateur_id" name="utilisateur_id" disabled>
        </div>

          <div class="mb-3">
            <label for="edit_recettes">Recettes</label>
            <input type="number" id="edit_recettes" name="recettes" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_depenses">Dépenses</label>
            <input type="number" id="edit_depenses" name="depenses" class="form-control">
          </div>

          <div class="mb-3">
            <label for="edit_date_jour">Date du jour</label>
            <input type="date" id="edit_date_jour" name="date_jour" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success">Mettre à jour</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editPointLivreurBtn");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            // Remplir les champs avec les données récupérées
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_utilisateur").value = this.dataset.utilisateur_nom + " " + this.dataset.utilisateur_prenoms;
            document.getElementById("edit_utilisateur_id").value = this.dataset.utilisateur_id;
            document.getElementById("edit_recettes").value = this.dataset.recettes;
            document.getElementById("edit_depenses").value = this.dataset.depenses;

            // ✅ Correction format date (on garde uniquement YYYY-MM-DD)
            let dateJour = this.dataset.date_jour.split(" ")[0];
            document.getElementById("edit_date_jour").value = dateJour;

            // ✅ Met à jour dynamiquement l’action du formulaire
            const form = document.getElementById("updatePointLivreurForm");
            form.action = "/points_livreurs/" + this.dataset.id; 
            // ⚡ si tu as une route nommée, utilise plutôt :
            // form.action = "{{ url('points_livreurs') }}/" + this.dataset.id;
        });
    });
});
</script>

