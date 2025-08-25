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
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editServiceInfo">
                  <div class="tab-pane" id="settings">
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
                        <label for="inputEmail" class="col-sm-2 col-form-label">Téléphone</label>
                        <div class="col-sm-10">
                          <input type="text" name="telephone" value="{{ $deliveryService->telephone }}" class="form-control" id="inputEmail" placeholder="Téléphone">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                          <input type="email" name="email" value="{{ $deliveryService->email }}" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Adresse</label>
                        <div class="col-sm-10">
                          <input type="text" name="adresse" value="{{ $deliveryService->adresse }}" class="form-control" id="inputSkills" placeholder="Adresse">
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
                  <div class="tab-pane" id="attribuerGerant">
                    <!-- The timeline -->

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

            <button type="submit" class="btn btn-success">
                Associer
            </button>
            <a href="{{ route('delivery_services.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Ancien mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="ancien_password" class="form-control" id="inputName" placeholder="Ancien mot de passe">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">ENmail</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
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

@endsection
