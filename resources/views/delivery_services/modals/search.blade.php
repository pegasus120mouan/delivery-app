<div class="modal fade" id="search-service" tabindex="-1" role="dialog" aria-labelledby="searchServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchServiceModalLabel">Rechercher un service de livraison</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('delivery_services.search') }}" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service_code">Code du service</label>
                        <input type="text" class="form-control" id="service_code" name="query" placeholder="Entrez le code du service">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>
    </div>
</div>