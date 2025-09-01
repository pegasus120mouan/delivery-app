@extends('layout.main')

@section('title', 'Liste des boutiques')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Liste des boutiques</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ Auth::user()->role }}</a></li>
              <li class="breadcrumb-item active">Boutiques</li>
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
                <h3>{{ $boutiques->count() }}</h3>

                <p>Boutiques Total</p>
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
              <h3>0</h3>

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
              <h3>{{ $boutiques->count() }}</h3>

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
              <h3>0</h3>

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

 <!--<h1 class="text-center">Liste des boutiques</h1>-->
 <!--   Début container pour le menu -->
    <div class="block-container">
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBoutiqueModal">
          <i class="fa fa-user-plus"></i> Enregistrer une boutique
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
                 <th>Logo</th>
                 <th>Services de livraison</th>
                 <th>Nom boutique</th>
                 <th>Email</th>
                 <th>Telephone</th>
                 <th>Adresse</th>
                 <th>Commune</th>
                 <th>Responsable</th>
                 <th>Statut</th>
                 <th>Actions</th>
                </tr>
             </thead>
             <tbody>
              @foreach ($boutiques as $boutique)
                <tr>
                    <td>
                    <a href="{{ route('boutiques.profile', $boutique->id) }}" class="update-logo-btn">
    <img src="{{ asset('storage/boutiques/' . $boutique->logo) }}"  
         alt="Logo" 
         width="50" 
         class="img-thumbnail"
         style="cursor: pointer;"
         title="Voir le profil">
</a>
                    </td>
                    <td>
                        @forelse($boutique->deliveryServices as $service)
                            {{ $service->nom }} <br>
                        @empty
                            <span class="badge badge-danger">Pas de service de livraison associé</span>
                        @endforelse
                    </td>
                    <td>{{ $boutique->nom_boutique }}</td>
                    <td>{{ $boutique->email }}</td>
                    <td>{{ $boutique->telephone }}</td>
                    <td>{{ $boutique->adresse }}</td>
                    <td>{{ $boutique->commune }}</td>
                    <td>
                      @forelse($boutique->clients as $customer)
                          {{ $customer->nom }} {{ $customer->prenoms }} <br>
                      @empty
                          <span class="badge badge-danger">Pas de gérant associé</span>
                      @endforelse
                    </td>
                    <td>
                        @if ($boutique->statut === 'Active')
                            <img src="{{ asset('img/verified.png') }}" 
                                alt="Logo" 
                                width="40">
                        @else
                            <img src="{{ asset('img/non_verified.png') }}" 
                                alt="Logo" 
                                width="40">
                        @endif
                    </td>
                    <td>
                        <a href="#" 
                            class="btn btn-primary edit-boutique"
                            data-id="{{ $boutique->id }}">
                            <i class="fas fa-edit"></i>
                          </a>
                        <form action="{{ route('boutiques.destroy', $boutique->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                    <td>
                    <a href="javascript:void(0)" 
                        class="btn btn-primary editServiceBtn" 
                        data-id="{{ $boutique->id }}"
                        data-nom="{{ $boutique->nom }}"
                        data-email="{{ $boutique->email }}"
                        data-telephone="{{ $boutique->telephone }}"
                        data-adresse="{{ $boutique->adresse }}"
                        data-toggle="modal" 
                        data-target="#updateServiceModal">
                        <i class="fa fa-edit"></i>
                    </a>
                        

                        <form action="{{ route('boutiques.destroy', $boutique->id) }}" method="POST" style="display: inline;">
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
        @include('boutiques.modals.add')
        <!--@include('boutiques.modals.update')-->

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