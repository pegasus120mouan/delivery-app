@extends('layout.main')

@section('title', 'Liste des utilisateurs')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gestion des utilisateurs</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ Auth::user()->role }}</a></li>
              <li class="breadcrumb-item active">Utilisateurs</li>
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
                <h3>{{ $utilisateurs->count() }}</h3>

                <p>Utilisateurs Total</p>
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
              <h3>{{ $utilisateurs->where('role', 'admin')->count() }}</h3>

                <p>Administrateurs</p>
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
            <div class="small-box bg-warning">
              <div class="inner">
              <h3>{{ $utilisateurs->where('role', 'livreur')->count() }}</h3>

                <p>Livreurs</p>
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
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>{{ $utilisateurs->where('role', 'client')->count() }}</h3>

                <p>Clients</p>
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

<h1 class="text-center">Liste des utilisateurs</h1>
 <!--   Début container pour le menu -->
    <div class="block-container">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
          <i class="fa fa-user-plus"></i> Enregistrer un utilisateur
      </button>



       <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add-point">
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
                    <th>Avatar</th>
                    <th>Service de livraison</th>
                    <th>Nom</th>
                    <th>Prenoms</th>
                    <th>Login</th>
                    <th>Role</th>
                    <th>Contact</th>
                    <th>Lieu d'Habitation</th>
                    <th>Whatsapp</th>
                    <th>Actions</th>
                </tr>
             </thead>
             <tbody>
                @foreach ($utilisateurs as $utilisateur)
                <tr>
                    <td>
                        <a href="{{ route('utilisateurs.profile', $utilisateur->id) }}">
                            <img src="{{ asset('storage/utilisateurs/' . $utilisateur->avatar) }}" 
                                alt="Avatar" 
                                class="img-circle" 
                                style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                title="Voir le profil">
                        </a>
                    </td>
                    <td>{{ $utilisateur->deliveryService?->nom ?? 'Non attribué' }}</td>
                    <td>{{ $utilisateur->nom }}</td>
                    <td>{{ $utilisateur->prenoms }}</td>
                    <td>{{ $utilisateur->login }}</td>
                    <td>{{ $utilisateur->role }}</td>
                    <td>{{ $utilisateur->contact }}</td>
                    <td>{{ $utilisateur->lieu_habitation }}</td>
                    <td>{{ $utilisateur->whatsapp }}</td>
                    <td>
                        <a href="{{ route('utilisateurs.edit', $utilisateur->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('utilisateurs.destroy', $utilisateur->id) }}" method="POST" style="display: inline;">
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
  @include('utilisateurs.modals.add')

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


@endsection