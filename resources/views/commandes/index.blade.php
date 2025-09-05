@extends('layout.main')

@section('title', 'Liste des commandes')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gestion des commandes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ Auth::user()->role }}</a></li>
              <li class="breadcrumb-item active">Commandes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3> {{ $commandes->where('date_reception', now()->toDateString())->count() ?? 0 }}</h3>

                <p>Commandes Total</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3> {{ $commandes->where('date_livraison', now()->toDateString())->count() ?? 0 }}</h3>

                <p>Commandes Livrées</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>{{ $commandes->where('statut', 'Non Livré')->where('date_reception', now()->toDateString())->count() ?? 0 }}</h3>

                <p>Commandes Non Livrées</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3>{{ $commandes->where('statut', 'Retourné')->where('date_retour', now()->toDateString())->count() ?? 0 }}</h3>

                <p>Commandes Retournées</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">

        <style>
    .block-container {
      background-color:  #d7dbdd ;
      padding: 20px;
      border-radius: 5px;
      width: 100%;
      margin-bottom: 20px;
    }
    
    thead th {
        position: sticky;
        top: 0;
        background-color: #000000 !important;
        color: #ffffff !important;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 12px 8px !important;
        vertical-align: middle;
        border: none;
    }
    
    /* Pour s'assurer que le contenu du thead est au-dessus du tbody */
    thead {
        position: relative;
        z-index: 11;
    }
    
    /* Style pour la première rangée du thead */
    thead tr:first-child th {
        border-top: none;
        border-bottom: 2px solid #444;
    }
    
    /* Style au survol des cellules d'en-tête */
    thead th:hover {
        background-color: #333 !important;
        cursor: pointer;
    }
   </style>

   <style>
    /* Fix for large pagination arrows */
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        margin-left: -1px;
        color: #0d6efd;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        position: relative;
        display: block;
        font-size: 1rem;
        line-height: 1.25;
    }
    
    .pagination .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .pagination .page-item:last-child .page-link {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    
    .pagination .page-link:hover {
        z-index: 2;
        color: #0a58ca;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    /* Ensure arrows are properly sized */
    .pagination .page-link svg,
    .pagination .page-link i {
        width: 1em !important;
        height: 1em !important;
        font-size: 1rem !important;
    }
    
    /* Remove any pseudo-elements that might create large arrows */
    .pagination .page-link::before,
    .pagination .page-link::after {
        display: none !important;
    }
   </style>

 <!-- <h1 class="text-center">Liste des services de livraison</h1> -->
 <!--   Début container pour le menu -->
    <div class="block-container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCommandeModal">
              <i class="fa fa-user-plus"></i> Enregistrer une commande
          </button>

          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#printPointModal">
              <i class="fa fa-print"></i> Imprimer un point
          </button>

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#search-commande">
              <i class="fa fa-search"></i> Recherche un point
            </button>

            <button type="button" class="btn btn-dark" onclick="window.location.href='export_commandes.php'">
              <i class="fa fa-print"></i> Exporter la liste des commandes
            </button>
     </div>

     <!--   Fin block container pour le menu -->

     <!-- Filtres -->
     <div class="block-container">
        <h5><i class="fa fa-filter"></i> Filtres de recherche</h5>
        <form method="GET" action="{{ route('commandes.index') }}" class="row g-3">
            <div class="col-md-2">
                <label for="code" class="form-label">Code commande</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ request('code') }}" placeholder="CMD-...">
            </div>
            
            <div class="col-md-2">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-select" id="statut" name="statut">
                    <option value="">Tous les statuts</option>
                    <option value="Livré" {{ request('statut') == 'Livré' ? 'selected' : '' }}>Livré</option>
                    <option value="Non Livré" {{ request('statut') == 'Non Livré' ? 'selected' : '' }}>Non Livré</option>
                    <option value="Retourné" {{ request('statut') == 'Retourné' ? 'selected' : '' }}>Retourné</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="boutique_id" class="form-label">Boutique</label>
                <select class="form-select" id="boutique_id" name="boutique_id">
                    <option value="">Toutes les boutiques</option>
                    @foreach($boutiques as $boutique)
                        <option value="{{ $boutique->id }}" {{ request('boutique_id') == $boutique->id ? 'selected' : '' }}>
                            {{ $boutique->nom_boutique }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="delivery_service_id" class="form-label">Service de livraison</label>
                <select class="form-select" id="delivery_service_id" name="delivery_service_id">
                    <option value="">Tous les services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('delivery_service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="date_reception" class="form-label">Date réception</label>
                <input type="date" class="form-control" id="date_reception" name="date_reception" value="{{ request('date_reception') }}">
            </div>
            
            <div class="col-md-2">
                <label for="date_livraison" class="form-label">Date livraison</label>
                <input type="date" class="form-control" id="date_livraison" name="date_livraison" value="{{ request('date_livraison') }}">
            </div>
            
            <div class="col-md-2">
                <label for="date_retour" class="form-label">Date retour</label>
                <input type="date" class="form-control" id="date_retour" name="date_retour" value="{{ request('date_retour') }}">
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fa fa-search"></i> Filtrer
                </button>
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
                    <i class="fa fa-refresh"></i> Réinitialiser
                </a>
            </div>
        </form>
     </div>

     <div class="table-responsive" style="max-height: 600px; overflow-y: auto; position: relative;">
    <table id="example2" class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%;">

             <thead>
                <tr style="background-color: #000000; color: #ffffff;">
                    <th>Code</th>
                    <th>Service de livraison</th>
                    <th>Communes</th>
                    <th>Cout global</th>
                    <th>Cout livraison</th>
                    <th>Cout reel</th>
                    <th>Boutique</th>
                    <th>Livreur</th>
                    <th>Statut</th>
                    <th>Date Reception</th>
                    <th>Date Livraison</th>
                    <th>Date Retour</th>
                    <th>Actions</th>
                    <th>Attribuer un livreur</th>
                    <th>Changer Statut livraison</th>
                    <th>Changer le client</th>
                </tr>
             </thead>
             <tbody>
                @foreach ($commandes as $commande)
                <tr>
                    <td>
                        <span class="badge badge-primary">{{ $commande->code ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $commande->deliveryService->nom ?? 'Non défini' }}</td>
                    <td>{{ $commande->communes }}</td>
                    <td>{{ $commande->cout_global }}</td>
                    <td>{{ $commande->cout_livraison }}</td>
                    <td>{{ $commande->cout_reel }}</td>
                    <td>{{ $commande->boutique->nom_boutique }}</td>
                    <td>
                        @if($commande->livreur)
                            <span class="badge bg-success">
                                {{ $commande->livreur->nom }} {{ $commande->livreur->prenoms }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Pas de livreur attribué
                            </span>
                        @endif
                    </td>
                    <td>
                       @if($commande->statut === 'Livré')
                                <img src="{{ asset('img/verified.png') }}" alt="Livré" width="30">
                            @elseif($commande->statut === 'Non Livré')
                                <img src="{{ asset('img/non_verified.png') }}" alt="Non Livré" width="30">
                            @else
                            <img src="{{ asset('img/double_arrow.png') }}" alt="Retourné" width="30">
                        @endif
                    
                    </td>
                    <td>{{ $commande->date_reception ? \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $commande->date_livraison ? \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $commande->date_retour ? \Carbon\Carbon::parse($commande->date_retour)->format('d/m/Y') : '-' }}</td>
                    <td>
                        <a href="javascript:void(0)" 
                                class="btn btn-primary editCommandeBtn" 
                                data-id="{{ $commande->id }}"
                                data-communes="{{ $commande->communes }}"
                                data-cout_global="{{ $commande->cout_global }}"
                                data-cout_livraison="{{ $commande->cout_livraison }}"
                                data-cout_reel="{{ $commande->cout_reel }}"
                                data-statut="{{ $commande->statut }}"
                                data-date_reception="{{ $commande->date_reception ? \Carbon\Carbon::parse($commande->date_reception)->format('Y-m-d') : '' }}"
                                data-date_livraison="{{ $commande->date_livraison ? \Carbon\Carbon::parse($commande->date_livraison)->format('Y-m-d') : '' }}"
                                data-date_retour="{{ $commande->date_retour ? \Carbon\Carbon::parse($commande->date_retour)->format('Y-m-d') : '' }}"
                                data-boutique_id="{{ $commande->boutique_id }}"
                                data-livreur_id="{{ $commande->livreur_id }}"
                                data-bs-toggle="modal" 
                                data-bs-target="#updateCommandeModal">
                                <i class="fa fa-edit"></i>
                        </a>

                        

                        <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                    <td>
                            <button type="button" class="btn btn-warning" 
                            data-bs-toggle="modal" data-bs-target="#attribuerLivreurModal" 
                            data-id="{{ $commande->id }}">
                            <i class="fa fa-user"></i> Attribuer un livreur
                            </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info" 
                            data-bs-toggle="modal" 
                            data-bs-target="#changeStatutLivraisonModal" 
                            data-id="{{ $commande->id }}">
                        <i class="fa fa-user"></i> Changer statut livraison
                        </button>
                    </td>

                    <td>
                        <button type="button" class="btn btn-dark" 
                                data-bs-toggle="modal" 
                                data-bs-target="#changeClientModal" 
                                data-id="{{ $commande->id }}">
                            <i class="fa fa-user"></i> Changer le client
                        </button>
                    </td>
                </tr>
                @endforeach
             </tbody>
     
     </table>
    </div>
</div>
        
      </div>
    </section>
   
  </div>
  @include('commandes.modals.add')
  @include('commandes.modals.update')
  @include('commandes.modals.attribuer_livreur')
  @include('commandes.modals.changer_statut')
  @include('commandes.modals.changer_boutique')
  @include('commandes.modals.print')

  <!-- Modal de Succès -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bg-success">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="successModalLabel">
                    <i class="fas fa-check-circle mr-2"></i>Succès
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center text-white">
                <i class="fas fa-check fa-3x mb-3"></i>
                <p id="successMessage">Opération effectuée avec succès!</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editCommandeBtn");
    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            // Récupérer les données de l'attribut data-*
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_communes").value = this.dataset.communes;
            document.getElementById("edit_cout_global").value = this.dataset.cout_global;
            document.getElementById("edit_cout_livraison").value = this.dataset.cout_livraison;
            // Ajouter la ligne suivante pour la date de réception
            document.getElementById("edit_date_reception").value = this.dataset.date_reception;
            
            // Modifier l'action du formulaire dynamiquement
            const form = document.getElementById("updateCommandeForm");
            form.action = "/commandes/" + this.dataset.id;
        });
    });
});
</script>

    <!-- Pagination professionnelle -->
    <div class="d-flex justify-content-between align-items-center mt-4 p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
        <!-- Informations sur les résultats -->
        <div class="text-white">
            <small class="opacity-75">Affichage de</small>
            <strong>{{ $commandes->firstItem() ?? 0 }} - {{ $commandes->lastItem() ?? 0 }}</strong>
            <small class="opacity-75">sur</small>
            <strong>{{ $commandes->total() }}</strong>
            <small class="opacity-75">résultats</small>
        </div>

        <!-- Navigation pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination mb-0 custom-pagination">
                <!-- Première page -->
                @if (!$commandes->onFirstPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $commandes->url(1) }}" title="Première page">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $commandes->previousPageUrl() }}" title="Page précédente">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </li>
                @endif

                <!-- Pages numérotées -->
                @php
                    $start = max(1, $commandes->currentPage() - 2);
                    $end = min($commandes->lastPage(), $commandes->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $commandes->url(1) }}">1</a>
                    </li>
                    @if ($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $commandes->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $commandes->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                @if ($end < $commandes->lastPage())
                    @if ($end < $commandes->lastPage() - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $commandes->url($commandes->lastPage()) }}">{{ $commandes->lastPage() }}</a>
                    </li>
                @endif

                <!-- Dernière page -->
                @if ($commandes->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $commandes->nextPageUrl() }}" title="Page suivante">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $commandes->url($commandes->lastPage()) }}" title="Dernière page">
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Sélecteur d'éléments par page -->
        <div class="d-flex align-items-center text-white">
            <small class="me-2 opacity-75">Éléments par page:</small>
            <select class="form-select form-select-sm custom-select" onchange="changePerPage(this.value)" style="width: auto;">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
    </div>

    <style>
    .custom-pagination .page-link {
        color: #495057;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.5rem 0.75rem;
        margin: 0 3px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .custom-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border-color: transparent;
        color: white;
        font-weight: bold;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(238, 90, 36, 0.4);
    }
    
    .custom-pagination .page-item.disabled .page-link {
        color: rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.1);
        cursor: not-allowed;
    }
    
    .custom-pagination .page-link:hover:not(.disabled) {
        background: rgba(255, 255, 255, 1);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: #333;
    }

    .custom-select {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        color: #333;
        font-weight: 500;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .custom-select:focus {
        background: rgba(255, 255, 255, 1);
        border-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
    }

    /* Animation d'entrée */
    .custom-pagination {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>

    <script>
    function changePerPage(perPage) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.set('page', 1);
        window.location = url.toString();
    }
    </script>
</div>
        
      </div>
    </section>
   
  </div>
  @include('commandes.modals.add')
  @include('commandes.modals.update')
  @include('commandes.modals.attribuer_livreur')
  @include('commandes.modals.changer_statut')
  @include('commandes.modals.changer_boutique')
  @include('commandes.modals.print')

  <!-- Modal de Succès -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bg-success">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="successModalLabel">
                    <i class="fas fa-check-circle mr-2"></i>Succès
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center text-white">
                <i class="fas fa-check fa-3x mb-3"></i>
                <p id="successMessage">Opération effectuée avec succès!</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editCommandeBtn");
    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            // Récupérer les données de l'attribut data-*
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_communes").value = this.dataset.communes;
            document.getElementById("edit_cout_global").value = this.dataset.cout_global;
            document.getElementById("edit_cout_livraison").value = this.dataset.cout_livraison;
            // Ajouter la ligne suivante pour la date de réception
            document.getElementById("edit_date_reception").value = this.dataset.date_reception;
            
            // Modifier l'action du formulaire dynamiquement
            const form = document.getElementById("updateCommandeForm");
            form.action = "/commandes/" + this.dataset.id;
        });
    });
});
</script>

@endsection

