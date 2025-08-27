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

     <div class="table-responsive" style="max-height: 600px; overflow-y: auto; position: relative;">
    <table id="example2" class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%;">

             <thead>
                <tr style="background-color: #000000; color: #ffffff;">
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

@endsection

