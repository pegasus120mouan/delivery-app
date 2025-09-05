@extends("layout.main")
@section("title", "Modifications de service de livraison")
@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile de {{ $deliveryService->nom }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Modifications de  Service de livraison</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('storage/delivery_services/' . $deliveryService->logo) }}"
                       alt="User profile picture">
                </div>
                <form action="{{ route('delivery_services.update-logo', $deliveryService) }}" method="POST" enctype="multipart/form-data">                
                  @csrf
                  @method('PUT')
                  <input type="file" name="logo" id="logo">
                  <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

                <h3 class="profile-username text-center">{{ $deliveryService->nom }}</h3>

                <p class="text-center {{ $deliveryService->adresse ? 'text-muted' : 'text-danger' }}">
                        {{ $deliveryService->adresse ?? 'Adresse non renseigné' }}
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nom</b> <a class="float-right">{{ $deliveryService->nom }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Telephone</b> <a class="float-right">{{ $deliveryService->telephone }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ $deliveryService->email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Statut</b> <a class="float-right">  @if($deliveryService->email_verified === null)
                     <img src="{{ asset('img/non_verifed.png') }}" alt="Non vérifié" width="20">
                       @else
                       <img src="{{ asset('img/verifed.png') }}" alt="Vérifié" width="20">
                       @endif</a>
                  </li>
                  <li class="list-group-item">
                    <b>Gérant</b> <a class="float-right">
                      @forelse($deliveryService->utilisateurs as $user)
                          {{ $user->nom }} {{ $user->prenoms }} <br>
                      @empty
                          <span class="badge badge-danger">Pas de gérant associé</span>
                      @endforelse
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Date de création</b> <a class="float-right">{{ $deliveryService->created_at->format('d/m/Y') }}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#editServiceInfo" data-toggle="tab">Modifier mes informations</a></li>
                  <li class="nav-item"><a class="nav-link" href="#attribuerGerant" data-toggle="tab">Attribuer un gérant</a></li>
                  <li class="nav-item"><a class="nav-link" href="#myBoutiques" data-toggle="tab">Mes boutiques</a></li>
                  <li class="nav-item"><a class="nav-link" href="#myDrivers" data-toggle="tab">Mes Livreurs</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editServiceInfo">
                    <form class="form-horizontal" action="{{ route('delivery_services.update', $deliveryService->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                          <input type="text" name="nom" value="{{ $deliveryService->nom }}" class="form-control" id="inputName" placeholder="nom">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputTelephone" class="col-sm-2 col-form-label">Téléphone</label>
                        <div class="col-sm-10">
                          <input type="text" name="telephone" value="{{ $deliveryService->telephone }}" class="form-control" id="inputTelephone" placeholder="Téléphone">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmailEdit" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                          <input type="email" name="email" value="{{ $deliveryService->email }}" class="form-control" id="inputEmailEdit" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputAdresse" class="col-sm-2 col-form-label">Adresse</label>
                        <div class="col-sm-10">
                          <input type="text" name="adresse" value="{{ $deliveryService->adresse }}" class="form-control" id="inputAdresse" placeholder="Adresse">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-large btn-success">Modifier les informations</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="attribuerGerant">
                    <form action="{{ route('delivery_services.updateGerant', $deliveryService->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                          <label for="gerant_id">Choisir un gérant</label>
                          <select name="gerant_id" id="gerant_id" class="form-control" required>
                              <option value="">-- Sélectionner --</option>
                              @foreach($gerants as $gerant)
                                  <option value="{{ $gerant->id }}">
                                      {{ $gerant->nom }} {{ $gerant->prenoms }} ({{ $gerant->email }})
                                  </option>
                              @endforeach
                          </select>
                      </div>
                      <button type="submit" class="btn btn-success">Associer</button>
                      <a href="{{ route('delivery_services.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="myBoutiques">

                    <div class="mb-3">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addBoutiqueModal">
                        Ajouter une boutique
                    </button>
                    </div>
                    @if($deliveryService->boutiques->count() > 0)
                      <table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Code Boutique</th>
                                  <th>Nom Boutique</th>
                                  <th>Contact Boutique</th>
                                  <th>Contact Gérant du service</th>
                              </tr>
                          </thead>
                    <tbody>
                        @foreach($deliveryService->boutiques as $boutique)
                            <tr>
                                <td><span class="badge badge-info">{{ $boutique->code }}</span></td>
                                <td>{{ $boutique->nom_boutique }}</td>
                                <td>
                                    @if($boutique->telephone)
                                        <i class="fas fa-phone mr-2"></i> {{ $boutique->telephone }}
                                        <br>
                                    @endif
                                    @if($boutique->email)
                                        <i class="fas fa-envelope mr-2"></i> {{ $boutique->email }}
                                    @endif
                                </td>
                                <td>  
                                    @forelse($deliveryService->utilisateurs->where('role', 'gerant') as $user)
                                        <strong>{{ $user->prenoms }} {{ $user->nom }}</strong><br>
                                        @if($user->contact)     
                                            <i class="fas fa-phone mr-2"></i> {{ $user->contact }}<br>
                                        @endif  
                                        @if($user->email)
                                            <i class="fas fa-envelope mr-2"></i> {{ $user->email }}
                                        @endif
                                        @if(!$loop->last)<hr>@endif
                                    @empty
                                        <span class="text-muted">Aucun gérant assigné</span>
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        @else
                          <div class="alert alert-info">
                              Aucune boutique n'est associée à ce service de livraison pour le moment.
                          </div>
                        @endif
                    </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="myDrivers">
                    <div class="mb-3">
                      <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addDriverModal">
                          Ajouter un livreur
                      </button>
                    </div>
                    @if($deliveryService->utilisateurs->where('role', 'livreur')->count() > 0)
                      <table class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Photo</th>
                                  <th>Code</th>
                                  <th>Nom</th>
                                  <th>Contact</th>
                                  <th>Email</th>
                                  <th>Statut</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($deliveryService->utilisateurs->where('role', 'livreur') as $driver)
                                  <tr>
                                      <td>
                                          <img src="{{ asset('storage/utilisateurs/' . $driver->avatar) }}" alt="Photo de {{ $driver->prenoms }} {{ $driver->nom }}" class="img-circle img-size-50 mr-2">
                                      </td>
                                      <td><span class="badge badge-primary">{{ $driver->code }}</span></td>
                                      <td>{{ $driver->prenoms }} {{ $driver->nom }}</td>
                                      <td>{{ $driver->contact }}</td>
                                      <td>{{ $driver->email }}</td>
                                      <td>
                                          <span class="badge badge-success">Actif</span>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                    @else
                      <div class="alert alert-info">
                          Aucun livreur n'est associé à ce service de livraison pour le moment.
                      </div>
                    @endif
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-- Modal pour ajouter une boutique -->
<div class="modal fade" id="addBoutiqueModal" tabindex="-1" aria-labelledby="addBoutiqueModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBoutiqueModalLabel">Ajouter une boutique</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('delivery_services.associate_boutique', $deliveryService->id) }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="boutique_id" class="form-label">Sélectionner une boutique</label>
            <select name="boutique_id" id="boutique_id" class="form-control" required>
              <option value="">-- Choisir une boutique --</option>
              @foreach($boutiques as $boutique)
                @if(!$deliveryService->boutiques->contains($boutique->id))
                  <option value="{{ $boutique->id }}">
                    {{ $boutique->code }} - {{ $boutique->nom_boutique }}
                    @if($boutique->commune)
                      ({{ $boutique->commune }})
                    @endif
                  </option>
                @endif
              @endforeach
            </select>
          </div>
          
          <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            Seules les boutiques non encore associées à ce service sont affichées.
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Associer la boutique</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal pour ajouter un livreur -->
<div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDriverModalLabel">Ajouter un livreur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('delivery_services.associate_driver', $deliveryService->id) }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="driver_id" class="form-label">Sélectionner un livreur</label>
            <select name="driver_id" id="driver_id" class="form-control" required>
              <option value="">-- Choisir un livreur --</option>
              @foreach($livreurs as $livreur)
                @if(!$deliveryService->utilisateurs->contains($livreur->id))
                  <option value="{{ $livreur->id }}">
                    {{ $livreur->code }} - {{ $livreur->prenoms }} {{ $livreur->nom }}
                    @if($livreur->contact)
                      ({{ $livreur->contact }})
                    @endif
                  </option>
                @endif
              @endforeach
            </select>
          </div>
          
          <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            Seuls les livreurs non encore associés à ce service sont affichés.
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Associer le livreur</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
