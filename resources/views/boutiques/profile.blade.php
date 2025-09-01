@extends("layout.main")
@section("title", "Modifications de boutique")
@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile de {{ $boutique->nom_boutique }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Modifications de  boutique</li>
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
                       src="{{ asset('storage/boutiques/' . $boutique->logo) }}"
                       alt="User profile picture">
                </div>
                <form action="{{ route('boutiques.update-logo', $boutique) }}" method="POST" enctype="multipart/form-data">                
                  @csrf
                  @method('PUT')
                  <input type="file" name="logo" id="logo">
                  <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

                <h3 class="profile-username text-center">{{ $boutique->nom_boutique }}</h3>

                <p class="text-center {{ $boutique->adresse ? 'text-muted' : 'text-danger' }}">
                        {{ $boutique->adresse ?? 'Adresse non renseigné' }}
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nom</b> <a class="float-right">{{ $boutique->nom_boutique }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Telephone</b> <a class="float-right">{{ $boutique->telephone }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ $boutique->email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Statut</b> <a class="float-right">  @if($boutique->email_verified === null)
                     <img src="{{ asset('img/non_verifed.png') }}" alt="Non vérifié" width="20">
                       @else
                       <img src="{{ asset('img/verifed.png') }}" alt="Vérifié" width="20">
                       @endif</a>
                  </li>
                  <li class="list-group-item">
                    <b>Gérant</b> <a class="float-right">
                      @forelse($boutique->clients as $customer)
                          {{ $customer->nom }} {{ $customer->prenoms }} <br>
                      @empty
                          <span class="badge badge-danger">Pas de clients associé</span>
                      @endforelse
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Date de création</b> <a class="float-right">{{ $boutique->created_at->format('d/m/Y') }}</a>
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
                  <li class="nav-item"><a class="nav-link" href="#showDeliveryServices" data-toggle="tab">Mes services de livraison</a></li>
                  <li class="nav-item"><a class="nav-link" href="#attribuerGerant" data-toggle="tab">Attribuer un gérant</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editServiceInfo">
                  <div class="tab-pane" id="settings">
                  <form class="form-horizontal" action="{{ route('boutiques.update', $boutique->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-10">
                          <input type="text" name="nom_boutique" value="{{ $boutique->nom_boutique }}" class="form-control" id="inputName" placeholder="nom">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Téléphone</label>
                        <div class="col-sm-10">
                          <input type="text" name="telephone" value="{{ $boutique->telephone }}" class="form-control" id="inputEmail" placeholder="Téléphone">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                          <input type="email" name="email" value="{{ $boutique->email }}" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Adresse</label>
                        <div class="col-sm-10">
                          <input type="text" name="adresse" value="{{ $boutique->adresse }}" class="form-control" id="inputSkills" placeholder="Adresse">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-large btn-success">Modifier les informations</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="showDeliveryServices">

                  <div class="mb-3">
                  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                      Ajouter un service de livraison
                  </button>
                  </div>
                   @if($boutique->deliveryServices->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Service de livraison</th>
                                <th>Contact Service</th>
                                <th>Gérant du service</th>
                                <th>Contact Gérant du service</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boutique->deliveryServices as $service)
                                <tr>
                                    <td>{{ $service->nom }}</td>
                                    <td>
                                        @if($service->telephone)
                                            <i class="fas fa-phone mr-2"></i> {{ $service->telephone }}
                                            @if($service->whatsapp)
                                                <a href="https://wa.me/{{ $service->whatsapp }}" target="_blank" class="text-success ml-2" title="Contacter sur WhatsApp">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                            @endif
                                            <br>
                                        @endif
                                        @if($service->email)
                                            <i class="fas fa-envelope mr-2"></i> {{ $service->email }}
                                        @endif
                                    </td>
                                    <td>
                            @forelse($service->utilisateurs as $user)
                                {{ $user->prenoms }} {{ $user->nom }}<br>
                            @empty
                                <span class="text-muted">Aucun utilisateur</span>
                            @endforelse
                        </td>
                        <td>
                            @forelse($service->utilisateurs as $user)
                                @if($user->contact)
                                    <i class="fas fa-phone mr-2"></i> {{ $user->contact }}
                                    @if($user->whatsapp)
                                        <a href="https://wa.me/{{ $user->whatsapp }}" target="_blank" class="text-success ml-2" title="Contacter sur WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                    <br>
                                @endif
                                @if($user->email)
                                    <i class="fas fa-envelope mr-2"></i> {{ $user->email }}
                                @endif
                                @if(!$loop->last)<hr>@endif
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        @else
                          <div class="alert alert-info">
                              Aucun service de livraison n'est associé à cette boutique pour le moment.
                          </div>
                        @endif
</div>
                
                <div class="tab-pane" id="attribuerGerant">
                    <!-- The timeline -->

                    <form action="{{ route('boutiques.updateClient', $boutique->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="client_id">Choisir un client</label>
                <select name="client_id" id="client_id" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->nom }} {{ $client->prenoms }} ({{ $client->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                Associer
            </button>
            <a href="{{ route('delivery_services.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </form>
                  </div>
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

@include('boutiques.modals.add-service')

@endsection
