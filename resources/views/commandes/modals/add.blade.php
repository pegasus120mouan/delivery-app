<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCommandeModal">
    <i class="fa fa-user-plus"></i> Enregistrer une commande
</button>

<div class="modal fade" id="addCommandeModal" tabindex="-1" aria-labelledby="addCommandeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('commandes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addCommandeModalLabel">Ajouter une commande</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Communes</label>
            <input type="text" name="communes" id="name" class="form-control" placeholder="Communes" required>      
          </div>
          <div class="mb-3">
            <label for="cout_global" class="form-label">Cout global</label>
            <input type="number" name="cout_global" id="cout_global" class="form-control" placeholder="Cout global" required>
          </div>
          <div class="mb-3">
            <label for="cout_livraison">Cout livraison</label>
            <select name="cout_livraison" id="cout_livraison" class="form-control">
                @foreach($coutLivraisons as $cout)
                    <option value="{{ $cout->cout_livraison }}">{{ $cout->cout_livraison }}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="boutique_id">Boutique</label>
            <select name="boutique_id" id="boutique_id" class="form-control">
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
