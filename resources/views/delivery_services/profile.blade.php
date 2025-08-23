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
                <form action="" method="POST" enctype="multipart/form-data">                @csrf
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
                  <li class="nav-item"><a class="nav-link active" href="#editInfo" data-toggle="tab">Modifier mes informations</a></li>
                  <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Changer mon mot de passe</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="editInfo">
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
                          <input type="text" name="telephone" value="{{ $deliveryService->telephone }}" class="form-control" id="inputEmail" placeholder="Prénoms">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" value="{{ $deliveryService->email }}" id="inputSkills" placeholder="E-mail">
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
                  <div class="tab-pane" id="changePassword">
                    <!-- The timeline -->

                    <form action="" method="POST">
                      @csrf
                      <div class="form-group row">
                        <label for="ancien_password" class="col-sm-2 col-form-label">Ancien mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="ancien_password" id="ancien_password" class="form-control @error('ancien_password') is-invalid @enderror" placeholder="Veuillez entrer votre ancien mot de passe" required>
                          @error('ancien_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nouveau_password" class="col-sm-2 col-form-label">Nouveau mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="nouveau_password" id="nouveau_password" class="form-control @error('nouveau_password') is-invalid @enderror" placeholder="Veuillez entrer votre nouveau mot de passe" required>
                          @error('nouveau_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="confirmer_nouveau_password" class="col-sm-2 col-form-label">Confirmer le mot de passe</label>
                        <div class="col-sm-10">
                          <input type="password" name="confirmer_nouveau_password" id="confirmer_nouveau_password" class="form-control @error('confirmer_nouveau_password') is-invalid @enderror" placeholder="Veuillez confirmer votre nouveau mot de passe" required>
                          @error('confirmer_nouveau_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-large btn-danger">Modifier mon mot de passe</button>
                        </div>
                      </div>
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
