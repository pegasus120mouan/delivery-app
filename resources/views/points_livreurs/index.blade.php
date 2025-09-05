@extends('layout.main')

@section('title', 'Points des livreurs')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gestion des points des livreurs</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ Auth::user()->role }}</a></li>
              <li class="breadcrumb-item active">Points des livreurs</li>
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
                <h3> {{ $pointsLivreurs->count() ?? 0 }}</h3>

                <p>Points Total</p>
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
              <h3> {{ $pointsLivreurs->where('statut', 'livré')->count() ?? 0 }}</h3>

                <p>Points Livrés</p>
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
              <h3>{{ $pointsLivreurs->where('statut', 'Non Livré')->count() ?? 0 }}</h3>

                <p>Points Non Livrés</p>
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
              <h3>{{ $pointsLivreurs    ->where('statut', 'Retourné')->count() ?? 0 }}</h3>

                <p>Points Retournés</p>
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
   </style>

 <!-- <h1 class="text-center">Liste des services de livraison</h1> -->
 <!--   Début container pour le menu -->
    <div class="block-container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPointModal">
          <i class="fa fa-user-plus"></i> Enregistrer un point
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

     <table id="example2" class="table table-bordered table-hover">

             <thead>
                <tr> 
                    <th>Service de livraison</th>
                    <th>Livreur</th>
                    <th>Recettes</th>
                    <th>Depenses</th>
                    <th>Gain</th>
                    <th>Date</th>
                    <th>Actions</th>
                    
                    
                </tr>
             </thead>
             <tbody>
                @foreach ($pointsLivreurs as $pointLivreur)
                <tr>
                    <td>{{ $pointLivreur->deliveryService->nom ?? 'N/A' }}</td>
                    <td>{{ $pointLivreur->utilisateur->nom }}  {{ $pointLivreur->utilisateur->prenoms }}</td>
                    <td>{{ $pointLivreur->recettes}}</td>
                    <td>{{ $pointLivreur->depenses }}</td>
                    <td>{{ $pointLivreur->gain_jour }}</td>
                    <td>{{ $pointLivreur->date_jour }}</td>
                    <td>
                    <a href="javascript:void(0)" 
   class="btn btn-primary editPointLivreurBtn" 
   data-id="{{ $pointLivreur->id }}"
   data-delivery_service_id="{{ $pointLivreur->delivery_service_id }}"
   data-utilisateur_id="{{ $pointLivreur->utilisateur_id }}"
   data-utilisateur_nom="{{ $pointLivreur->utilisateur->nom }}"
   data-utilisateur_prenoms="{{ $pointLivreur->utilisateur->prenoms }}"
   data-recettes="{{ $pointLivreur->recettes }}"
   data-depenses="{{ $pointLivreur->depenses }}"
   data-date_jour="{{ $pointLivreur->date_jour }}"
   data-bs-toggle="modal" 
   data-bs-target="#updatePointLivreurModal">
   <i class="fa fa-edit"></i>
</a>



                        

                        <form action="{{ route('points_livreurs.destroy', $pointLivreur->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
             </tbody>
     
          </table>
          
        </div>
        
      </div>
    </section>
   
  </div>
  @include('points_livreurs.modals.add')
  @include('points_livreurs.modals.update')

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

